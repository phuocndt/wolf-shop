<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    /**
     * The function `upload` in PHP validates and uploads an image file to Cloudinary, returning the secure URL or an
     * error message.
     *
     * @param Request $request The `upload` function in the code snippet you provided is a PHP function that handles
     * image uploads. It takes a `Request` object as a parameter, which is typically an HTTP request containing the
     * uploaded image file.
     *
     * @return a JSON response with either a success message and the uploaded file URL if the upload was successful,
     * or an error message if the upload failed.
     */
    public function upload(Request $request)
    {
        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Upload the image to Cloudinary
        try {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

            // You can now store this URL in your database if needed
            return response()->json([
                'success' => true,
                'url' => $uploadedFileUrl,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Image upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
