<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\MediaObjectRepository;
use App\Repository\MediaPostRepository;
use App\Http\Responses\ApiResponse;

class MediaObjectController extends Controller
{
    protected $mediaObjectRepository;
    protected $mediaPostRepository;

    public function __construct(MediaObjectRepository $mediaObjectRepository, MediaPostRepository $mediaPostRepository)
    {
        $this->mediaObjectRepository = $mediaObjectRepository;
        $this->mediaPostRepository = $mediaPostRepository;
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

        $module = $request->query('module');

        if ($module === 'post' && $request->has('post_id')) return ApiResponse::success($this->mediaPostRepository->create($file, $request->input('post_id')), 'Media object updated successfully');

        return ApiResponse::success($this->mediaObjectRepository->createMediaObject($file), 'Media object updated successfully');
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

        // dd($persistedMediaObject);

        if (array_key_exists('error', $persistedMediaObject)) {
            return ApiResponse::error($persistedMediaObject['error'], [], 404);
        }

        return ApiResponse::success($persistedMediaObject, 'Media object updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $module = $request->query('module');

        if ($module === 'post') return ApiResponse::success($this->mediaPostRepository->delete($id), 'Media object deleted successfully');

        $mediaObject = $this->mediaObjectRepository->deleteMediaObject($id);
        if (!$mediaObject) {
            return ApiResponse::error('Media object not found', [], 404);
        }

        return ApiResponse::success($mediaObject, 'Media object deleted successfully');
    }
}
