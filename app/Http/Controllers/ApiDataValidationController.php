<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiDataValidationController extends Controller
{
    //

    public function validateApiData(Request $request)
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
                $expectedFormat = [
                    'data' => [
                        'id' => 'integer',
                        'name' => 'string',
                    ],
                ];

                $validator = Validator::make($responseData, $expectedFormat);
                if ($validator->fails()) {
                    return response()->json(['error' => 'API response data validation failed'], 422);
                }
                return response()->json(['data' => $responseData]);
            } else {
                return response()->json(['error' => 'API request failed'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
