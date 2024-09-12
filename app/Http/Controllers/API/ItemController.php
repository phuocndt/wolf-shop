<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Items;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Items::paginate(10);
    }

    public function createItem(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
        ]);

        return Items::create($data);
    }
}
