<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function getVideosData()
    {
        // TODO: include pagination
        // $id = $request->query();

        return Video::select(['id', 'title', 'thumbnail_path'])->paginate(6);
    }

    public function getVideoThumb(string $fileName)
    {
        $localPath = '/thumbnails\/'.$fileName;
        if (!Storage::disk('local')->exists($localPath)) {
            abort(404);
        }

        $thumb = Storage::get($localPath);
        $type = Storage::mimeType($localPath);

        return response($thumb, 200)->header('Content-Type', $type);
    }
}
