<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * The index function returns a paginated list of posts with 10 posts per page.
     *
     * @return The `index` function is returning a paginated list of `Post` models with 10 items per page.
     */
    public function index()
    {
        return Post::paginate(10);
    }

    /**
     * The function `createPost` takes a request, validates the data for title, content, and user_id, then creates a
     * new post with the validated data.
     *
     * @param Request $request The `createPost` function is a method that creates a new post based on the data
     * provided in the request. The function expects a `Request` object as a parameter, which contains the data
     * needed to create the post.
     *
     * @return The `createPost` function is returning a new `Post` model instance created with the validated data
     * received from the request.
     */
    public function createPost(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'content' => ['required', 'string', 'max:5000'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        return Post::create($data);
    }
}
