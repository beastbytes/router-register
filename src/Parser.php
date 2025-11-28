<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Route as RouteAttribute;
use BeastBytes\Router\Register\DTO\Group;
use BeastBytes\Router\Register\DTO\Route;
use BeastBytes\Router\Register\Route\GroupInterface;
use ReflectionClass;
use ReflectionEnumBackedCase;
use ReflectionMethod;

/**
 * Parses RouterRegister attributes in application source code and generates an array of tree structures
 * each of which represent the groups and routes, and their attributes (host and middleware), in a top level group
 * as defined in the application Group Enumeration.
 */
final class Parser
{
    private const DEFAULT_GROUP_NAME = 'routes';

    /**
     * @psalm-var array{string: Group}
     */
    private array $groups = [];
    private string $name;

    public function processFiles(array $files): array
    {
        foreach ($files as $file) {
            $this->processFile($file);
        }

        return $this->groups;
    }

    private function processFile(string $file): void
    {
        $group = null;
        $className = $this->getClassName($file);

        if (!class_exists($className)) {
            return;
        }

        $reflectionClass = new ReflectionClass($className);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $attributes = new MethodAttributes($reflectionMethod);
            $routeAttribute = $attributes->getRoute();

            $route = $routeAttribute instanceof RouteAttribute
                ? Route::create($routeAttribute)
                    ->action(new Middleware([$reflectionClass->getName(), $reflectionMethod->getName()]))
                    ->defaultValues($attributes->getDefaultValues())
                    ->fallback($attributes->getFallback())
                    ->hosts($attributes->getHosts())
                    ->middlewares($attributes->getMiddlewares())
                    ->override($attributes->getOverride())
                    ->parameters($attributes->getParameters())
                : null
            ;

            if ($route instanceof Route) {
                if ($group === null) {
                    $group = $this->createGroup($route);
                }

                if ($route->isHoisted()) {
                    $this->groups[$this->name]->route($route->group($group));
                } else {
                    $group->route($route->group($group));
                }
            }
        }

        $this->groups[$this->name]->route($group);
    }

    private function createGroup(Route $route): Group
    {
        $attributes = new GroupAttributes(new ReflectionClass($route->getRoute()->getRoute()));
        $parent = $attributes->getGroup()->getParent();

        $this->name = $parent instanceof GroupInterface ? $parent->name : self::DEFAULT_GROUP_NAME;

        if (!array_key_exists($this->name, $this->groups)) {
            $this->groups[$this->name] = $this->createTopLevelGroup($parent);
        }

        return Group::create($attributes->getGroup()->getName(), $attributes->getPrefix()?->getPrefix())
            ->hosts($attributes->getHosts())
            ->cors($attributes->getCors())
            ->middlewares($attributes->getMiddlewares())
        ;
    }

    private function createTopLevelGroup(?GroupInterface $group): Group
    {
        if (!$group instanceof GroupInterface) {
            return Group::create(self::DEFAULT_GROUP_NAME);
        }

        $reflectionCase = new ReflectionEnumBackedCase($group, $group->name);
        $attributes = new GroupAttributes($reflectionCase);
        $commonAttributes = new GroupAttributes($reflectionCase->getDeclaringClass());

        return Group::create($group->name, $group->getPrefix())
            ->hosts(array_merge($commonAttributes->getHosts(), $attributes->getHosts()))
            ->cors($commonAttributes->getCors() ?? $attributes->getCors())
            ->middlewares(array_merge($commonAttributes->getMiddlewares(), $attributes->getMiddlewares()))
        ;
    }

    private function getClassName(string $filename): string
    {
        $namespace = '';
        $stream = fopen($filename, 'r+');

        do {
            $line = fgets($stream);
            if (str_starts_with($line, 'namespace')) {
                $namespace = substr($line, 10, -2);
            }
        } while (empty($namespace));

        fclose($stream);

        $class = substr($filename, strrpos($filename, '/') + 1, -4);

        return $namespace . '\\' . $class;
    }
}