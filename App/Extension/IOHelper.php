<?php
    class IOHelper
    {
        public static function ReadFile($filePath)
        {
            $file = fopen($filePath,"r");
            $content = fread($file,filesize($filePath));
            fclose($file);
            return $content;
        }
        public static function WriteFile($filePath,$content)
        {
            $file = fopen($filePath,"w");
            fwrite($file,$content);
            fclose($file);
        }
        public static function DeleteFile($filePath)
        {
            if (file_exists($filePath))
            {
                unlink($filePath);
            }
        }
    };
?>