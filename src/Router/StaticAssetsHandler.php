<?php

namespace SigmaPHP\Core\Router;

use SigmaPHP\Router\Interfaces\StaticAssetsHandlerInterface;

/**
 * Static Assets Handler Class
 */
class StaticAssetsHandler implements StaticAssetsHandlerInterface
{
    /**
     * Get file's MIME.
     *
     * As mention in the useful comments in the PHP docs, both pathinfo() and
     * mime_content_type() functions will fail to get the correct MIME, unless
     * we do configurations, like setting magicfile in the PHP INI, to make sure
     * that the framework out of the box can handle majority (most common) file
     * types out there, included with the Router a modified version of the httpd
     * server (apache) to be used as lookup table for file MIME.
     *
     * references:
     * - https://www.php.net/manual/en/function.mime-content-type.php
     * - https://www.php.net/manual/en/function.mime-content-type.php#107798
     * - https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
     *
     * @param string $extension
     * @return string
     */
    private function getFileMime($extension)
    {
        $extensions = [];

        foreach (explode("\n", file_get_contents(__DIR__ . '/mime.types'))
            as $line)
        {
            $extensions = explode(',', $line, 2);

            if (preg_match("/\b{$extension}\b/", $extensions[1])) {
                return $extensions[0];
            }
        }

        return 'application/octet-stream';
    }

    /**
     * Serve static assets files.
     *
     * @param string $resourcePath
     * @return resource
     */
    public function handle($resourcePath)
    {
        $resourcePath = str_replace(config('app.base_path'), '', $resourcePath);
        $resourcePath = root_path('public/' . $resourcePath);

        if (!file_exists($resourcePath)) {
            return container('response')->responseData(
                container('view')->render('errors/404'),
                'text/html',
                404
            );
        }

        return container()->get('response')->responseData(
            file_get_contents($resourcePath),
            $this->getFileMime(pathinfo($resourcePath, PATHINFO_EXTENSION)),
            200,
            [
                'Content-Disposition' => 'inline;'
            ]
        );
    }
}
