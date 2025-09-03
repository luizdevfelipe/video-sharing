<?php

namespace App\Http\Controllers;

use App\Enums\VideoVisibilityEnum;
use App\Models\Video;
use App\Services\CommentService;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function __construct(
        private readonly Request $request,
        private readonly VideoService $videoService,
        private readonly CommentService $commentService
    ) {}

    /**
     * Get a paginated list of videos with their titles and thumbnails.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getVideosData(): LengthAwarePaginator
    {
        // TODO: include pagination
        // $id = $request->query();

        return Video::select(['id', 'title', 'thumbnail_path'])
            ->where('visibility', VideoVisibilityEnum::PUBLIC)
            ->paginate(6);
    }

    public function getVideoFile(string $fileName)
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);

        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'ts') {
            $path = substr($baseName, 0, -1);
            $localPath =  "videos/$path/$baseName.ts";
        } else {
            $localPath =  "videos/$baseName/$baseName.m3u8";
        }

        if (!Storage::disk('local')->exists($localPath)) {
            abort(404);
        }

        $video = Storage::get($localPath);
        $type = Storage::mimeType($localPath);

        return response($video, 200)->header('Content-Type', $type);
    }

    /**
     * Get the thumbnail image for a video.
     *
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function getVideoThumb(string $fileName)
    {
        $localPath = '/thumbnails\/' . $fileName;
        if (!Storage::disk('local')->exists($localPath)) {
            abort(404);
        }

        $thumb = Storage::get($localPath);
        $type = Storage::mimeType($localPath);

        return response($thumb, 200)->header('Content-Type', $type);
    }

    /**
     * Get the data for a specific video.
     *
     * @param int $videoId
     * @return JsonResponse
     */
    public function getVideoData(int $videoId): JsonResponse
    {
        $video = $this->videoService->getVideoData($videoId);

        return response()->json(
            [
                'title' => $video->title,
                'description' => $video->description,
                'video_file' => $video->video_path,
            ],
            200
        );
    }

    /**
     * Get the comments for a video.
     *
     * @param int $videoId
     * @return JsonResponse
     */
    public function getComments(int $videoId): JsonResponse
    {
        $video = $this->videoService->getVideoById($videoId);

        $comments = $this->commentService->getComments($video->id);

        return response()->json($comments, 200);
    }

    /**
     * Register a comment for a video.
     *
     * @param int $videoId
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addComment(int $videoId): JsonResponse
    {
        $data = $this->request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $video = $this->videoService->getVideoById($videoId);

        $comment = $video->comments()->create([
            'user_id' => $this->request->user()->id,
            'content' => $data['content'],
        ]);

        return response()->json([
            'id' => $comment->id,
            'user_name' => $this->request->user()->name,
            'content' => $comment->content
        ], 200);
    }
}
