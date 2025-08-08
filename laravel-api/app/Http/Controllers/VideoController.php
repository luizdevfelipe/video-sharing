<?php

namespace App\Http\Controllers;

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

        return Video::select(['id', 'title', 'thumbnail_path'])->paginate(6);
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

    public function getComments(int $videoId)
    {
        $video = $this->videoService->getVideoById($videoId);

        $comments = $this->commentService->getComments($video->id);

        return response()->json($comments, 200);
    }
}
