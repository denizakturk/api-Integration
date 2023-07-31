<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiRateLimitingController extends Controller
{
    public function apiRateLimiting(Request $request)
    {
        $url = $request->input('url');
        $params = $request->input('params', []);
        $method = $request->input('method', 'GET');
        try {
            $response = Http::withHeaders([
                'Content-Type' => $request->headers->get("Content-Type"),
            ])->asForm()->{$method}($url, $params);
            if ($response->successful()) {
                $responseData = $response->json();
                return response()->json(['data' => $responseData]);
            } else {
                return response()->json(['error' => 'API request failed'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
