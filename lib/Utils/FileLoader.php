<?php

namespace Flynt\Utils;

use DirectoryIterator;

class FileLoader
{
    /**
     * Iterates through a directory and executes the provided callback function
     * on each file or folder in the directory (excluding dot files).
     *
     * @since 0.1.0
     *
     * @param $dir string Absolute path to the directory.
     * @param $callback callable The callback function.
     *
     * @return array An array of the callback results.
     */
    public static function iterateDir($dir, callable $callback)
    {
        $output = [];

        if (!is_dir($dir)) {
            return $output;
        }

        $directoryIterator = new DirectoryIterator($dir);

        foreach ($directoryIterator as $file) {
            if ($file->isDot()) {
                continue;
            }
            $callbackResult = call_user_func($callback, $file);
            array_push($output, $callbackResult);
        }

        return $output;
    }

    /**
     * Recursively require all files in a specific directory.
     *
     * By default, requires all php files in a specific directory once.
     * Optionally able to specify the files in an array to load in a certain order.
     * Starting and trailing slashes will be stripped for the directory and all files provided.
     *
     * @since 0.1.0
     *
     * @param string $dir Directory to search through.
     * @param array $files Optional array of files to include. If this is set, only the files specified will be loaded.
     */
    public static function loadPhpFiles($dir, $files = [])
    {
        $dir = trim($dir, '/');

        if (count($files) === 0) {
            $dir = get_template_directory() . '/' . $dir;

            self::iterateDir($dir, function ($file) {
                if ($file->isDir()) {
                    $dirPath = trim(str_replace(get_template_directory(), '', $file->getPathname()), '/');
                    self::loadPhpFiles($dirPath);
                } elseif ($file->isFile() && $file->getExtension() === 'php') {
                    $filePath = $file->getPathname();
                    require_once $filePath;
                }
            });
        } else {
            array_walk($files, function ($file) use ($dir) {
                $filePath = $dir . '/' . ltrim($file, '/');

                if (!locate_template($filePath, true, true)) {
                    trigger_error(
                        sprintf('Error locating %s for inclusion', $filePath),
                        E_USER_ERROR
                    );
                }
            });
        }
    }
}
