<?php

namespace Assigment;

class FileHelper
{
    /**
     * This function groups all files in the provided directory with their prefix as directory name and move the files
     * to the specific folder
     *
     * @param string $directory
     * @param string $separator
     *
     * @return void
     */
    public static function groupFilesByPrefix($directory, $separator): void
    {
        if (strpos($directory, '/') === false) {
            $directory .= DIRECTORY_SEPARATOR;
        }

        $handle = opendir($directory);
        if ($handle === false) {
            echo "Unable to open directory: $directory" . PHP_EOL;
            exit(0);
        }

        while ($file = readdir($handle)) {
            if ($file == '.' || $file == '..' || strpos($file, $separator) === false) {
                continue;
            }

            $file_parts = explode($separator, $file);
            $last_key = key(array_slice($file_parts, -1, 1, true));
            unset($file_parts[$last_key]);

            $prefixed_dirname = $directory . implode($separator, $file_parts);
            if (!is_dir($prefixed_dirname)) {
                mkdir($prefixed_dirname);
            }

            rename($directory . $file, $prefixed_dirname . DIRECTORY_SEPARATOR . $file);
        }
    }
}