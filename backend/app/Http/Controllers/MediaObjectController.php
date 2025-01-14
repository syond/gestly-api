<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\MediaObjectRepository;
use App\Http\Responses\ApiResponse;

class MediaObjectController extends Controller
{
    protected $mediaObjectRepository;

    public function __construct(MediaObjectRepository $mediaObjectRepository)
    {
        $this->mediaObjectRepository = $mediaObjectRepository;
    }

    public function list()
    {
        $mediaObjects = $this->mediaObjectRepository->listMediaObjects();
        return $mediaObjects;
    }

    public function show($id)
    {
        $mediaObject = $this->mediaObjectRepository->showMediaObject($id);

        if (!$mediaObject) {
            return ApiResponse::error('Media object not found', [], 404);
        }

        return $mediaObject;
    }

    public function create(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        // ]);

        if (!$request->hasFile('file')) {
            return ApiResponse::error('Media file not provided', [], 404);
        }

        $file = $request->file('file');

        return $this->mediaObjectRepository->createMediaObject($file);
    }

    public function update(Request $request, $id)
    {
         // $request->validate([
        //     'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        // ]);

        if (!$request->hasFile('file')) {
            return ApiResponse::error('Media file not provided', [], 404);
        }

        $file = $request->file('file');

        $persistedMediaObject = $this->mediaObjectRepository->updateMediaObject($file, $id);

        if (array_key_exists('error', $persistedMediaObject)) {
            return ApiResponse::error($persistedMediaObject['error'], [], 404);
        }

        return ApiResponse::success($persistedMediaObject, 'Media object updated successfully');
    }

    public function delete($id)
    {
        $mediaObject = $this->mediaObjectRepository->showMediaObject($id);
        if (!$mediaObject) {
            return ApiResponse::error('Media object not found', [], 404);
        }

        return ApiResponse::success($mediaObject, 'Media object deleted successfully');
    }
}
