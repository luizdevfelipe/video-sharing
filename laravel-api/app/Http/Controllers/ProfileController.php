<?php

namespace App\Http\Controllers;

use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller 
{
    /**
     * Create a new controller instance.
     * @param VideoService $videoService
     */
    public function __construct(private readonly VideoService $videoService) 
    {

    }
      
    /**
     * Save the uploaded video
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadVideo(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'bail|required|string|max:255|min:10',
            'description' => 'bail|required|string|max:3000|min:100',
            'categories' => 'bail|required|array|exists:categories,name',
            'video' => 'bail|required|file|mimes:mp4,mov,avi,wmv|max:20480',
            'thumbnail' => 'bail|required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filePaths = $this->videoService->storageNewUploadedVideoFiles($data['video'], $data['thumbnail']);
   
        $this->videoService->createVideo(
            $data['title'],
            $data['description'],
            $data['categories'],
            $filePaths['video'],
            $filePaths['thumbnail']
        );

        return response()->json(['message' => 'Video uploaded successfully!'], 200);
    }
}
