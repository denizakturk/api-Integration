<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function authenticate(Request $request)
    {
        $apiKey = $request->input('api_key');
        $secret = $request->input('secret');

        $validApiKey = env("API_KEY");
        $validSecret = env("API_SECRET");

        if ($apiKey === $validApiKey && $secret === $validSecret) {
            return response()->json(['message' => 'Authentication successful']);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
