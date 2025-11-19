<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\Group as GroupAttribute;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Route as RouteAttribute;
use BeastBytes\Router\Register\DTO\Group;
use BeastBytes\Router\Register\DTO\Route;
use ReflectionClass;
use ReflectionMethod;
use Yiisoft\Files\FileHelper;

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

    public function processFiles(array $files): array
    {
        foreach ($files as $file) {
            $this->processFile($file);
        }

        return $this->groups;
    }

    private function processFile(string $file): void
    {
        $name = $prefix = null;
        $className = $this->getClassName($file);

        if (!class_exists($className)) {
            return;
        }

        $reflectionClass = new ReflectionClass($className);

        $attributes = new GroupAttributes($reflectionClass);
        $groupAttribute = $attributes->getGroup();

        if ($groupAttribute instanceof GroupAttribute) {
            $name = $groupAttribute->getGroupName();
            $prefix = $groupAttribute->getGroupPrefix();
        }

        if ($name === null) {
            $name = self::DEFAULT_GROUP_NAME;
        }

        $group = (array_key_exists($name, $this->groups))
            ? $this->groups[$name]
            : Group::create($name, $prefix)
        ;
        $group = $group
            ->hosts($attributes->getHosts())
            ->cors($attributes->getCors())
            ->middlewares($attributes->getMiddlewares())
        ;
        $group = $this->processClass($reflectionClass, $group);

        $this->groups[$name] = $group;
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

    private function processClass(ReflectionClass $reflectionClass, Group $group): Group
    {
        $name = $prefix = null;
        $routes = [];

        $attributes = new GroupAttributes($reflectionClass);
        $groupAttribute = $attributes->getGroup();

        if ($groupAttribute instanceof GroupAttribute) {
            $name = $groupAttribute->getName();
            $prefix = $groupAttribute->getPrefix();
        }

        if ($name === null || $prefix === null) {
            $nx = mb_strtolower(
                preg_replace(
                    '/(?<=\p{L})(\p{Lu})/u',
                    '-' . '\1',
                    str_replace(['Action', 'Controller'], '', $reflectionClass->getShortName())
                )
            );

            $name = $name ?? $nx;
            $prefix = match(gettype($prefix)) {
                'boolean' => null,
                'string' => $prefix,
                'NULL' => '/' . $nx
            };
        }

        $attributes = new ClassAttributes($reflectionClass);
        $classGroup = Group::create($name, $prefix)
            ->hosts($attributes->getHosts())
            ->middlewares($attributes->getMiddlewares())
        ;

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $routes[] = $this->processMethod($reflectionClass, $reflectionMethod);
        }

        foreach ($routes as $route) {
            if ($route instanceof Route) {
                if ($route->isHoisted()) {
                    $group->route($route->group($classGroup));
                } else {
                    $classGroup->route($route->group($classGroup));
                }
            }
        }

        return $classGroup instanceof Group ? $group->route($classGroup) : $group;
    }

    private function processMethod(
        ReflectionClass $reflectionClass,
        ReflectionMethod $reflectionMethod,
    ): ?Route
    {
        $attributes = new MethodAttributes($reflectionMethod);
        $routeAttribute = $attributes->getRoute();

        if ($routeAttribute instanceof RouteAttribute) {
            return Route::create($routeAttribute)
                ->action(new Middleware([$reflectionClass->getName(), $reflectionMethod->getName()]))
                ->defaultValues($attributes->getDefaultValues())
                ->fallback($attributes->getFallback())
                ->hosts($attributes->getHosts())
                ->middlewares($attributes->getMiddlewares())
                ->override($attributes->getOverride())
                ->parameters($attributes->getParameters())
            ;
        }

        return null;
    }
}