<?php

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



if (!function_exists('saveImage')) {

    function saveImage($image, $path = 'attachments'): array
    {
        try {

            $options = [
                "cloud_name" => config('cloudinary.cloud_name'),
                "folder" => $path,
                "timeout" => 6000000,
            ];

            $options["public_id"] = pathinfo(time().rand(1, 1000), PATHINFO_FILENAME);

            $response = Cloudinary::upload(
                $image,
                $options
            );

            sleep(1);

            return [
                'path' 		=> $response->getSecurePath(),
                'public_id' => $response->getPublicId()
            ];

        }

        catch (\Throwable $ex)
        {
            return [
                'path' 		=> '',
                'public_id'	=> '',
                'message'	=> $ex->getMessage()
            ];
        }
    }
}
