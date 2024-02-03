<?php

namespace Flynt\Utils;

use DirectoryIterator;

/**
 * Provides a set of methods that are used to load files.
 */
class FileLoader
{
    /**
     * Iterates through a directory and executes the provided callback function
     * on each file or folder in the directory (excluding dot files).
     *
     * @since 0.1.0
     *
     * @param string $dir Absolute path to the directory.
     * @param callable $callback The callback function.
     *
     * @return array An array of the callback results.
     */
    public static function iterateDir(string $dir, callable $callback): array
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
            $output[] = $callbackResult;
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
    public static function loadPhpFiles(string $dir, array $files = []): void
    {
        $dir = trim($dir, '/');

        if ($files === []) {
            $dir = get_template_directory() . '/' . $dir;
            $phpFiles = [];

            self::iterateDir($dir, function ($file) use (&$phpFiles): void {
                if ($file->isDir()) {
                    $dirPath = trim(str_replace(get_template_directory(), '', $file->getPathname()), '/');
                    self::loadPhpFiles($dirPath);
                } elseif ($file->isFile() && $file->getExtension() === 'php') {
                    $filePath = $file->getPathname();
                    $phpFiles[] = $filePath;
                }
            });

            // Sort files alphabetically.
            sort($phpFiles);
            foreach ($phpFiles as $phpFile) {
                require_once $phpFile;
            }
        } else {
            sort($files);

            foreach ($files as $file) {
                $filePath = $dir . '/' . ltrim($file, '/');

                if (locate_template($filePath, true, true) === '' || locate_template($filePath, true, true) === '0') {
                    trigger_error(
                        sprintf(__('Error locating %s for inclusion', 'flynt'), $filePath),
                        E_USER_ERROR
                    );
                }
            }
        }
    }
}
