<?php

namespace Valet\Drivers\Custom;

use Valet\Drivers\ValetDriver;

class PerchRunwayValetDriver extends ValetDriver
{
    // Array of possible folders for Perch Runway. Change as needed.
    private $folders = ['admin', 'build', 'control', 'perch', 'public', 'site_admin'];
    
    // Configuration variable for the static files path. Change as needed.
    private const STATIC_FILES_PATH = '/dist/';

    /**
     * Determine if the driver serves the request.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return bool
     */
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        $folder = $this->getFolder($sitePath);

        if ($folder && strpos($uri, $folder) === false) {
            return is_dir($sitePath . '/' . $folder . '/core/runway');
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return string
     */
    public function frontControllerPath(string $sitePath, string $siteName, string $uri): string
    {
        $_SERVER['PHP_SELF'] = $uri;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];

        $folder = $this->getFolder($sitePath);

        // If the URI starts with '/control/', serve the Perch Runway application
        if (strpos($uri, '/control/') === 0) {
            return $sitePath . '/control/core/runway/start.php';
        }

        // If the URI doesn't start with '/control/', try to serve the start.php file
        return $sitePath . '/' . $folder . '/core/runway/start.php';
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return string|false
     */
    public function isStaticFile(string $sitePath, string $siteName, string $uri)
    {
        // Check if the URI starts with the static files path
        if (strpos($uri, self::STATIC_FILES_PATH) === 0) {
            $staticFilePath = $sitePath . $uri;
            if (is_file($staticFilePath)) {
                return $staticFilePath;
            }
        }

        return false;
    }

    /**
     * Get active folder of project
     *
     * @param string $sitePath
     * @return string
     */
    protected function getFolder(string $sitePath): string
    {
        $activeFolder = false;

        foreach ($this->folders as $folder) {
            $isDirectory = is_dir($sitePath . '/' . $folder . '/core/runway');
            if ($isDirectory) {
                $activeFolder = $folder;
                break;
            }
        }

        return $activeFolder;
    }
}
