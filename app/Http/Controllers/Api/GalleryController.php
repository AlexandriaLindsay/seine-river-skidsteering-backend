<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn (GalleryItem $item) => [
                'id' => $item->id,
                'caption' => $item->caption,
                'category' => $item->category,
                'image_url' => Storage::disk('public')->url($item->image_path),
            ]);

        return response()->json($items);
    }
}