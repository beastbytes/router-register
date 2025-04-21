<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

final class Writer
{
    private string $path;

    public function setPath(string $path): self
    {
        $this->path = $path;

        if (!is_dir($path)) {
            mkdir($path);
        }

        if (!is_dir($path . DIRECTORY_SEPARATOR . 'routes')) {
            mkdir($path . DIRECTORY_SEPARATOR . 'routes');
        }

        return $this;
    }

    public function write(array $groups): string
    {
        $content = <<<'GROUP'
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
GROUP;

        foreach ($groups as $name => $group) {
            $result = $this->writeRoutes($name, $group['routes']);

            if (strlen($result) > 0) {
                return $result;
            }

            $content .= "\n    " . join("\n        ->", $group['group']) . "\n    ,";
        }

        $filename = $this->path . DIRECTORY_SEPARATOR . 'groups.php';
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

    private function writeRoutes(string $groupName, array $routes): string
    {
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

        $filename = $this->path . DIRECTORY_SEPARATOR . 'routes'  . DIRECTORY_SEPARATOR . $groupName . '.php';
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