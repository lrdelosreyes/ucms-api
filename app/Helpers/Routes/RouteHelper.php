<?php

namespace App\Helpers\Routes;

class RouteHelper {
    public static function includeRouteFiles(string $folder) {
        $dirIterator = new \RecursiveDirectoryIterator($folder);

        /**
         * @var \RecursiveDirectoryIterator |
         * @var \RecursiveIteratorIterator $it
         **/

        $it = new \RecursiveIteratorIterator($dirIterator);

        while ($it->valid()) {
            if (!$it->isDot() &&
                $it->isFile() &&
                $it->isReadable() &&
                $it->current()->getExtension() === 'php') {
                require $it->key();
            }

            $it->next();
        }

        #require __DIR__ . '/api/v1/users.php';
        #require __DIR__ . '/api/v1/contacts.php';
    }
}
