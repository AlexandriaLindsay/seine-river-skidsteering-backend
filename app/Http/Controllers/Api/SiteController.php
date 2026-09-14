<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class SiteController extends Controller
{
    public function settings()
    {
        return response()->json(SiteSetting::current());
    }
}