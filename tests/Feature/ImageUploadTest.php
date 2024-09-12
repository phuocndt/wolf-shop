<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @description Test image upload via API
     * @Group imageUpload
     */
    public function testImageUpload()
    {
        // Use the real image from the fixtures folder
        $filePath = base_path('tests/Fixtures/test_image.jpg');
        $file = new UploadedFile($filePath, 'test_image.jpg', null, null, true);

        // Send POST request to the upload endpoint with the file
        $response = $this->postJson('/api/upload-image', [
            'image' => $file,
        ]);

        // Assert response status is 401 (or whatever is expected)
        $response->assertStatus(401);

        // You can add additional assertions based on the response structure
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
