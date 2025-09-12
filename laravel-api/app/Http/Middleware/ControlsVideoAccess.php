<?php

namespace App\Http\Middleware;

use App\Enums\VideoVisibilityEnum;
use App\Services\VideoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ControlsVideoAccess
{
    public function __construct(private VideoService $videoService) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $fileName = $request->route('fileName');

        $video = $this->videoService->getVideoByFileOrBaseName($fileName);

        if (!$video) {
            abort(404, __('status.video_404'));
        }

        if (
            $video->visibility == VideoVisibilityEnum::PUBLIC->value ||
            $video->visibility == VideoVisibilityEnum::PROTECTED->value
        ) {
            return $next($request);
        }

        if (!$request->user()) {
            abort(403, __('status.login_required'));
        }

        //TODO: check the permission of the user to access the video through the user_videos table

        if (!app(VideoService::class)->isVideoAccessibleByUser($fileName, $request->user())) {
            abort(403, __('status.private_video'));
        }

        return $next($request);
    }
}
