<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Route;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yiisoft\Files\FileHelper;
use Yiisoft\Files\PathMatcher\PathMatcher;

final class Generator
{
    private string $defaultGroup;

    public function processFile(string $file): ?array
    {
        $className = $this->getClassName($file);

        if (!class_exists($className)) {
            return null;
        }

        $routes = [];

        $reflectionClass = new ReflectionClass($className);

        [$name, $group] = $this->processGroupAttribute($reflectionClass);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $route = $this->processMethod($reflectionClass, $reflectionMethod);

            if (!empty($route)) {
                $routes[] = $route;
            }
        }

        return [$name, $group, $routes];
    }

    public function setDefaultGroup(string $defaultGroup): self
    {
        $this->defaultGroup = $defaultGroup;
        return $this;
    }

    private function getClassName(string $file): string
    {
        $namespace = '';
        $stream = FileHelper::openFile($file, 'r+');

        do {
            $line = fgets($stream);
            if (str_starts_with($line, 'namespace')) {
                $namespace = substr($line, 10, -2);
            }
        } while (empty($namespace));

        fclose($stream);

        $class = substr($file, strrpos($file, '/') + 1, -4);

        return $namespace . '\\' . $class;
    }

    private function processGroupAttribute(ReflectionClass $reflectionClass): array
    {

        $groupAttributes = $reflectionClass
            ->getAttributes(Group::class, ReflectionAttribute::IS_INSTANCEOF)
        ;

        if (count($groupAttributes) === 0) {
            $name = $this->defaultGroup;
            $prefix = null;
            $groupAttribute = null;
        } else {
            $groupAttribute = $groupAttributes[0]->newInstance();

            $name = $groupAttribute->getName();
            if ($name === null) {
                $name = $this->defaultGroup;
            }

            $prefix = $groupAttribute->getPrefix();
        }

        $group = ['Group::create(' . (is_string($prefix) ? "'$prefix'" : null) . ')'];

        if ($groupAttribute) {
            $this->groupNamePrefix($group, $groupAttribute);
            $this->groupHosts($group, $groupAttribute);
            $this->groupCors($group, $groupAttribute);
            $this->groupMiddleware($group, $groupAttribute);
            $this->groupDisabledMiddleware($group, $groupAttribute);
        }

        $this->groupRoutes($group, $name);

        return [$name, $group];
    }

    private function groupRoutes(array &$group, string $name): void
    {
        $group[] = "routes(...(require __DIR__ . '/routes/" . $name . ".php'))";
    }

    private function groupCors(array &$group, Group $groupAttribute): void
    {
        $cors = $groupAttribute->getCors();

        if ($cors !== null) {
            $group[] = "withCors('$cors')";
        }
    }

    private function groupDisabledMiddleware(array &$group, Group $groupAttribute): void
    {
        $middlewares = $groupAttribute->getDisabledMiddleware();

        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                $group[] = "disabledMiddleware('$middleware')";
            }
        }
    }

    private function groupHosts(array &$group, Group $groupAttribute): void
    {
        $hosts = $groupAttribute->getHosts();

        if (count($hosts) > 0) {
            $group[] = "hosts('" . join("', '", $hosts) . "')";
        }
    }

    private function groupMiddleware(array &$group, Group $groupAttribute): void
    {
        $middlewares = $groupAttribute->getMiddleware();

        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                $group[] = "middleware('$middleware')";
            }
        }
    }

    private function groupNamePrefix(array &$group, Group $groupAttribute): void
    {
        $namePrefix = $groupAttribute->getNamePrefix();

        if (is_string($namePrefix)) {
            $group[] = "namePrefix($namePrefix)";
        }
    }

    private function processMethod(ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod): ?array
    {
        /** @var list<string> $route */
        $route = [];

        $methodAttributes = new MethodAttributes($reflectionMethod);

        $routeAttribute = $methodAttributes->getRoute();

        if ($routeAttribute === null) {
            return null;
        }

        $classAttributes = new ClassAttributes($reflectionClass);

        $this->routeMethods($route, $routeAttribute, $classAttributes, $methodAttributes);
        $this->routeDefaults($route, $classAttributes, $methodAttributes);
        $this->routeName($route, $routeAttribute, $classAttributes);
        $this->routeOverride($route, $methodAttributes);
        $this->routeHosts($route, $routeAttribute, $classAttributes);
        $this->routeMiddleware($route, $routeAttribute, $classAttributes);
        $this->routeDisabledMiddleware($route, $routeAttribute);
        $this->routeAction($route, $reflectionClass, $reflectionMethod);
        $this->routeFallback($route, $methodAttributes);

        return $route;
    }

    /**
     * @param list<string> $route
     * @param ReflectionClass $reflectionClass
     * @param ReflectionMethod $reflectionMethod
     */
    private function routeAction(
        array &$route,
        ReflectionClass $reflectionClass,
        ReflectionMethod $reflectionMethod
    ): void
    {
        $route[] = 'action([' . $reflectionClass->getName() . "::class, '" . $reflectionMethod->getName() . "'])";
    }

    private function routeDefaults(
        array &$route,
        ClassAttributes $classAttributes,
        MethodAttributes $methodAttributes
    ): void
    {
        $defaultValues = [];

        foreach ([
                     $classAttributes->getDefaults(),
                     $methodAttributes->getDefaults()
                 ] as $defaultAttributes) {
            foreach ($defaultAttributes as $defaultAttribute) {
                $defaultValues[$defaultAttribute->getParameter()] = $defaultAttribute->getValue();
            }
        }

        if (count($defaultValues) > 0) {
            $default = "default([\n";

            foreach ($defaultValues as $parameter => $value) {
                $default .= "'" . $parameter . "' => '" . $value . "',\n";
            }

            $route[] = $default . '])';
        }
    }

    private function routeFallback(
        array &$route,
        MethodAttributes $methodAttributes
    ): void
    {
        if ($methodAttributes->getFallback() !== null) {
            $route['fallback'] = true;
        }
    }

    /**
     * @param list<string> $route
     * @param Route $routeAttribute
     * @param ClassAttributes $classAttributes
     */
    private function routeHosts(
        array &$route,
        Route $routeAttribute,
        ClassAttributes $classAttributes,
    ): void
    {
        $hosts = [];

        foreach ($classAttributes->getHosts() as $host) {
            $hosts[] = $host->getHost();
        }

        $hosts = array_merge($hosts, $routeAttribute->getHosts());

        if (count($hosts) > 0) {
            $route[] = "hosts('" . join("', '", $hosts) . "')";
        }
    }

    /**
     * @param list<string> $route
     * @param Route $routeAttribute
     */
    private function routeDisabledMiddleware(
        array &$route,
        Route $routeAttribute
    ): void
    {
        $middlewares = $routeAttribute->getDisableMiddleware();

        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                $route[] = "disableMiddleware('$middleware')";
            }
        }
    }

    /**
     * @param list<string> $route
     * @param Route $routeAttribute
     * @param ClassAttributes $classAttributes
     * @param MethodAttributes $methodAttributes
     */
    private function routeMethods(
        array &$route,
        Route $routeAttribute,
        ClassAttributes $classAttributes,
        MethodAttributes $methodAttributes
    ): void
    {
        $parameters = $methodAttributes->getParameters();
        $prefix = $classAttributes->getPrefix();
        $methods = $routeAttribute->getMethods();
        $uri = $routeAttribute->getUri();

        if (count($parameters) > 0) {
            $replacements = [];

            foreach ($parameters as $parameter) {
                $name = $parameter->getName();
                $pattern = $parameter->getPattern();

                $replacements['{' . $name . '}'] = '{' . $name . ':' . $pattern . '}';
            }

            $uri = ($prefix === null ? '' : $prefix->getRoutePrefix()) . strtr($uri, $replacements);
        }

        $route[] = "Route::methods(['" . join("','", $methods) . "'], '" . $uri . "')";
    }

    /**
     * @param list<string> $route
     * @param Route $routeAttribute
     * @param ClassAttributes $classAttributes
     */
    private function routeMiddleware(
        array &$route,
        Route $routeAttribute,
        ClassAttributes $classAttributes,
    ): void
    {
        $middlewares = [];

        foreach ($classAttributes->getMiddleware() as $middleware) {
            $middlewares[] = $middleware->getMiddleware();
        }

        $middlewares = array_merge($middlewares, $routeAttribute->getMiddleware());

        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                $route[] = "middleware('$middleware')";
            }
        }
    }

    /**
     * @param list<string> $route
     * @param Route $routeAttribute
     * @param ClassAttributes $classAttributes
     */
    private function routeName(
        array &$route,
        Route $routeAttribute,
        ClassAttributes $classAttributes,
    ): void
    {
        $prefix = $classAttributes->getPrefix();

        $name = ($prefix === null ? '' : $prefix->getNamePrefix()) . $routeAttribute->getName();

        $route[] = "name('" . $name . "')";
    }

    private function routeOverride(
        array &$route,
        MethodAttributes $methodAttributes
    ): void
    {
        if ($methodAttributes->getOverride() !== null) {
            $route[] = 'override()';
        }
    }
}