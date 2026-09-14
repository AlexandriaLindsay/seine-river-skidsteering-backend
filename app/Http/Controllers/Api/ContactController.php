<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:60'],
            'service_interested' => ['nullable', 'string', 'max:191'],
            'message' => ['required', 'string', 'max:2000'],
            // Honeypot field: real users never fill this in, bots usually do.
            'website' => ['prohibited'],
        ]);

        unset($validated['website']);

        ContactSubmission::create($validated);

        return response()->json(['message' => 'Thanks — we\'ll be in touch soon.'], 201);
    }
}