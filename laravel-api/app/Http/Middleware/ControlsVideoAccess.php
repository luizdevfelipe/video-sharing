<?php

namespace App\Http\Middleware;

use App\Enums\VideoVisibilityEnum;
use App\Services\VideoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            abort(403, 'requires_auth');
        }

        if (!$this->videoService->isVideoAccessibleByUser($video, $user)) {
            abort(403, 'private_video');
        }

        return $next($request);
    }
}
