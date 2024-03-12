<?php

namespace app\util;

class View
{
    public static function render($filename)
    {
        $viewsDir = 'app/views/';

        $phpFilePath = $viewsDir . $filename . '.php';
        $htmlFilePath = $viewsDir . $filename . '.html';

        if (file_exists($phpFilePath)) {
            include $phpFilePath;
        } else if (file_exists($htmlFilePath)) {
            include $htmlFilePath;
        } else {
            echo "Error: View not found";
        }
    }
}
