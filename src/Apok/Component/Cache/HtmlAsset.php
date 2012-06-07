<?php
namespace Apok\Component\Cache;

class HtmlAsset
{
    public static $appDirectory;

    public static $webPath;

    private static $templates = array(
        'css' => "<link rel=\"stylesheet\" href=\"%s\" />\n",
        'js'  => "<script src=\"%s\"></script>\n"
    );

    /**
     *
     */
    private static function fileWithCacheParam($file)
    {
        $fileWithParam = null;

        if (is_file(self::$appDirectory.$file)) {
            $fileWithParam = self::$webPath.$file.'?v='.filemtime(self::$appDirectory.$file);
        }

        return $fileWithParam;
    }

    /**
     * Embed JS file with proper caching parameters
     *
     * @param   string $file
     */
    public static function embedFileToHtml($file)
    {
        $template = null;

        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (isset(self::$templates[$extension])
            && $fileWithParam = self::fileWithCacheParam($file)) {

            $template = sprintf(self::$templates[$extension], $fileWithParam);
        }

        return $template;
    }
}