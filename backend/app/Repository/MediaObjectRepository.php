<?php

namespace App\Repository;

use App\Utils;
use App\Repository\MediaPostRepository;
use App\Models\MediaObject;

class MediaObjectRepository
{
    public function listMediaObjects()
    {
        return MediaObject::all();
    }

    protected function mediaObjectFactory($uploadedFile)
    {
        $fileNameWithoutExtension = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $fileName = time() . '_' . Utils::toSnakeCase($fileNameWithoutExtension) . '.' . $fileExtension;
        $fileType = $uploadedFile->getClientMimeType();
        $filePath = $uploadedFile->storeAs('uploads', $fileName, 'public');

        return [
            'fileName' => $fileName,
            'filePath' => $filePath,
            'fileType' => $fileType,
            'fileExtension' => $fileExtension,
        ];
    }

    public function createMediaObject($uploadedFile)
    {
        $fileObject = $this->mediaObjectFactory($uploadedFile);

        $mediaObject = MediaObject::create(
            [
                'file_name' => $fileObject['fileName'],
                'file_path' => $fileObject['filePath'],
                'file_type' => $fileObject['fileType'],
                'file_extension' => $fileObject['fileExtension'],
            ]
        );

        return $mediaObject;
        // $mediaPost = new MediaPostRepository();
        // $module = $request->query('module');

        // if ($module === 'post') return $mediaPost->createMediaPost($request);
        // if ($module === 'user') return $mediaUser->createMediaUser($request);
    }

    public function updateMediaObject($uploadedFile, $id)
    {
        $mediaObject = MediaObject::find($id);

        if (!$mediaObject) {
            return ['error' => 'Media object not found'];
        }

        $fileObject = $this->mediaObjectFactory($uploadedFile);

        $mediaObject->update([
            'file_name' => $fileObject['fileName'],
            'file_path' => $fileObject['filePath'],
            'file_type' => $fileObject['fileType'],
            'file_extension' => $fileObject['fileExtension'],
        ]);

        return $mediaObject;
    }

    public function deleteMediaObject($id)
    {
        $mediaObject = MediaObject::find($id);
        return $mediaObject->delete();
    }

    public function showMediaObject($id)
    {
        $mediaObject = MediaObject::find($id);
        return $mediaObject;
    }
}
