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
        $identifier = $request->route('fileName') ?? $request->route('videoId');
        
        if ($identifier === null) {
            abort(400, __('status.bad_request'));
        } else if (is_numeric($identifier) && intval($identifier) == $identifier) {
            $video = $this->videoService->getVideoById($identifier);
        } else {
            $video = $this->videoService->getVideoByFileOrBaseName($identifier);
        }

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

        if (!$this->videoService->isVideoAccessibleByUser($video, $request->user())) {
            abort(403, __('status.private_video'));
        }

        return $next($request);
    }
}
