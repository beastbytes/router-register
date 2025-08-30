<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\Route;
use ReflectionClass;
use ReflectionMethod;
use Yiisoft\Files\FileHelper;

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

        [$name, $group] = $this->processGroupAttributes($reflectionClass);

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

    private function processGroupAttributes(ReflectionClass $reflectionClass): array
    {
        $groupAttributes = new GroupAttributes($reflectionClass);

        $groupAttribute = $groupAttributes->getGroup();

        if ($groupAttribute === null) {
            $name = $this->defaultGroup;
            $prefix = null;
        } else {
            $name = $groupAttribute->getName();
            if ($name === null) {
                $name = $this->defaultGroup;
            }

            $prefix = $groupAttribute->getPrefix();
        }

        $group = ['Group::create(' . (is_string($prefix) ? "'$prefix'" : null) . ')'];

        if ($groupAttribute !== null) {
            $this->groupNamePrefix($group, $groupAttributes);
            $this->hosts($group, [$groupAttributes]);
            $this->groupCors($group, $groupAttributes);
            $this->middleware($group, [$groupAttributes]);
        }

        $this->groupRoutes($group, $name);

        return [$name, $group];
    }

    private function groupRoutes(array &$group, string $name): void
    {
        $group[] = "routes(...(require __DIR__ . '/routes/" . $name . ".php'))";
    }

    private function groupCors(array &$group, GroupAttributes $groupAttributes): void
    {
        $corsAttribute = $groupAttributes->getCors();

        if ($corsAttribute !== null) {
            $middleware = $corsAttribute->getMiddleware();

            if (is_array($middleware)) {
                $group[] = 'withCors(' . $this->array2String($middleware) . ')';
            } elseif (str_starts_with($middleware, 'fn') || str_starts_with($middleware, 'function')) {
                $group[] = "withCors($middleware)";
            } else {
                $group[] = "withCors('$middleware')";
            }
        }
    }

    private function groupNamePrefix(array &$group, GroupAttributes $groupAttributes): void
    {
        $namePrefixAttribute = $groupAttributes->getPrefix();

        if ($namePrefixAttribute === null) {
            $namePrefix = $groupAttributes->getGroup()->getNamePrefix();
        } else {
            $namePrefix = $namePrefixAttribute->getNamePrefix();
        }

        $group[] = "namePrefix('$namePrefix')";
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

        $this->routeMethods($route, $routeAttribute, $methodAttributes);
        $this->defaultValues($route, [$classAttributes, $methodAttributes]);
        $this->routeName($route, $routeAttribute);
        $this->routeOverride($route, $methodAttributes);
        $this->hosts($route, [$classAttributes, $methodAttributes]);
        $this->middleware($route, [$classAttributes, $methodAttributes]);
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

    private function defaultValues(array &$route, array $attributeObjects): void
    {
        $defaultValues = [];

        foreach ($attributeObjects as $attributeObject) {
            foreach ($attributeObject->getDefaults() as $defaultAttribute) {
                $defaultValues[] = "'"
                    . $defaultAttribute->getParameter()
                    . "' => '"
                    . $defaultAttribute->getValue() .
                    "'"
                ;
            }
        }

        if (count($defaultValues) > 0) {
            $route[] = 'defaults([' . implode(', ', $defaultValues) . '])';;
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

    private function hosts(array &$groute, array $attributeObjects): void
    {
        $hosts = [];

        foreach ($attributeObjects as $attributeObject) {
            foreach ($attributeObject->getHosts() as $hostAttribute) {
                $hosts[] = $hostAttribute->getHost();
            }
        }

        if (count($hosts) === 1) {
            $groute[] = "host('" . $hosts[0] . "')";
        } elseif (count($hosts) > 1) {
            $groute[] = "hosts('" . implode("', '", $hosts) . "')";
        }
    }

    private function routeMethods(
        array &$route,
        Route $routeAttribute,
        MethodAttributes $methodAttributes
    ): void
    {
        $parameters = $methodAttributes->getParameters();
        $prefix = $routeAttribute->getPrefix();
        $methods = $routeAttribute->getMethods();
        $uri = $routeAttribute->getUri();

        if (str_starts_with($uri, '//')) {
            $uri = mb_substr($uri, 1);
        } else {
            $uri = (is_string($prefix) ? '/' . $prefix : '') . $uri;
        }

        if (count($parameters) > 0) {
            $replacements = [];

            foreach ($parameters as $n => $parameter) {
                $name = $parameter->getName();
                $pattern = $parameter->getPattern();
                $replacements['{' . $name . '}'] = '{' . $name . ':' . $pattern . '}';
            }

            $uri = strtr($uri, $replacements);
        }

        $route[] = "Route::methods(['" . join("', '", $methods) . "'], '" . $uri . "')";
    }

    private function middleware(array &$grpoute, array $attributeObjects): void
    {
        $middlewares = [];
        $disabledMiddlewares = [];

        foreach ($attributeObjects as $attributeObject) {
            foreach ($attributeObject->getMiddlewares() as $middlewareAttribute) {
                $middleware = $middlewareAttribute->getMiddleware();

                if (is_array($middleware)) {
                    $middleware = $this->array2String($middleware);
                    if ($middlewareAttribute->disable()) {
                        $disabledMiddlewares[] = "$middleware";
                    } else {
                        $middlewares[] = "$middleware";
                    }
                } elseif (str_starts_with($middleware, 'fn') || str_starts_with($middleware, 'function')) {
                    if ($middlewareAttribute->disable()) {
                        $disabledMiddlewares[] = "$middleware";
                    } else {
                        $middlewares[] = "$middleware";
                    }
                } else {
                    if ($middlewareAttribute->disable()) {
                        $disabledMiddlewares[] = "'$middleware'";
                    } else {
                        $middlewares[] = "'$middleware'";
                    }
                }
            }
        }

        foreach ($disabledMiddlewares as $d => $disabledMiddleware) {
            $m = array_search($disabledMiddleware, $middlewares);

            if (is_int($m)) {
                unset($disabledMiddlewares[$d], $middlewares[$m]);
            }
        }

        array_walk(
            $disabledMiddlewares,
            fn(&$disabledMiddleware, $key) => $disabledMiddleware = "disabledMiddleware($disabledMiddleware)"
        );

        array_walk(
            $middlewares,
            fn(&$middleware, $key) => $middleware = "middleware($middleware)"
        );

        $grpoute = [...$grpoute, ...$middlewares, ...$disabledMiddlewares];
    }

    private function routeName(
        array &$route,
        Route $routeAttribute
    ): void
    {
        $route[] = "name('" . $routeAttribute->getName() . "')";
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

    private function array2String(array $ary): string
    {
        $string = '[';

        foreach ($ary as $k => $v) {
            if (is_string($k)) {
                $string .= "'$k' => ";

                if (is_array($v)) {
                    $string .= $this->array2String($v);
                } elseif (is_string($v)) {
                    $string .= "'$v'";
                } else {
                    $string .= "$v";
                }
            }
            $string .= ', ';
        }

        return $string . ']';
    }
}
