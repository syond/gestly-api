<?php

namespace App\Repository;

use App\Models\MediaPost;
use App\Repository\MediaObjectRepository;

class MediaPostRepository
{
    public function create($uploadedFile, $postId)
    {
        $mediaObjectRepository = new MediaObjectRepository();
        $file = $mediaObjectRepository->createMediaObject($uploadedFile);

        $mediaPost = MediaPost::create([
            'media_object_id' => $file->id,
            'post_id' => $postId,
        ]);

        return $mediaPost;
    }

    public function delete($id)
    {
        $mediaPost = MediaPost::find($id);

        if (!$mediaPost) {
            return ['error' => 'Media post not found'];
        }

        $mediaObjectRepository = new MediaObjectRepository();
        $mediaObjectRepository->deleteMediaObject($mediaPost->media_object_id);

        $mediaPost->delete($id);

        return $mediaPost;
    }
}
