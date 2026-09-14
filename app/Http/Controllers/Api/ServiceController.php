<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Service $service) => [
                'id' => $service->id,
                'title' => $service->title,
                'slug' => $service->slug,
                'icon' => $service->icon,
                'summary' => $service->summary,
                'description' => $service->description,
                'image_url' => $service->image_path ? Storage::disk('public')->url($service->image_path) : null,
            ]);

        return response()->json($services);
    }
}