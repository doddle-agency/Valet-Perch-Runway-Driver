<?php

namespace Valet\Drivers\Custom;

use Valet\Drivers\ValetDriver;

class PerchRunwayValetDriver extends ValetDriver
{
    private $folders = ['admin', 'build', 'control', 'perch', 'public', 'site_admin',];

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

		// Determine the correct path based on the presence of the folder in the URI
		if (strpos($uri, $folder) !== false) {
			// If the folder is in the URI, use the default front controller path
			return $sitePath . '/' . $folder . '/core/runway/start.php';
		}

		// If the folder is not in the URI, use the default front controller path
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
        $staticFilePath = $sitePath . '/dist/' . $uri;

        if (file_exists($staticFilePath)) {
            return $staticFilePath;
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
