<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes;

class Writer
{
    public function write(string $path, array $groups): string
    {
        $content = <<<'GROUP'
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
GROUP;

        foreach ($groups as $name => $group) {
            $result = $this->writeRoutes($path, $name, $group['routes']);

            if (strlen($result) > 0) {
                return $result;
            }

            $content .= "\n    " . join("\n        ->", $group['group']) . "\n    ,";
        }

        $filename = $path . DIRECTORY_SEPARATOR . 'groups.php';
        $result = file_put_contents(
            $filename,
            $content . "\n];",
            LOCK_EX
        );

        if ($result === false) {
            return "Failed to write \"$filename\"";
        }

        return '';
    }

    private function writeRoutes(string $path, string $groupName, array $routes): string
    {
        $path .= DIRECTORY_SEPARATOR . 'routes';
        $fallback = null;

        $content = <<<'ROUTE'
<?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
ROUTE;

        foreach ($routes as $route) {
            if (array_key_exists('fallback', $route)) {
                if ($fallback !== null) {
                    return "Duplicate Fallback route in $groupName group";
                }

                unset($route['fallback']);
                $fallback = $route;
            } else {
                $content .= "\n    " . join("\n        ->", $route) . "\n    ,";
            }
        }

        if ($fallback !== null) {
            $content .= "\n    " . join("\n        ->", $fallback) . "\n    ,";
        }

        $filename = $path  . DIRECTORY_SEPARATOR . $groupName . '.php';
        $result = file_put_contents(
            $filename,
            $content . "\n];",
            LOCK_EX
        );

        if ($result === false) {
            return "Failed to write \"$filename\"";
        }

        return '';
    }
}