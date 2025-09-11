<?php 

namespace App\Helpers;

class VideoPathHelper 
{
    public static function generateVideoFileLocalPath(string $fileName): string
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);

        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'ts') {
            $path = substr($baseName, 0, -1);
            return "videos/$path/$baseName.ts";
        } else {
            return "videos/$baseName/$baseName.m3u8";
        }
    }
}