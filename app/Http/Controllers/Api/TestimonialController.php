<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()
            ->where('published', true)
            ->orderBy('sort_order')
            ->get(['id', 'customer_name', 'location', 'rating', 'quote']);

        return response()->json($testimonials);
    }
}