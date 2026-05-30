<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Http\Resources\ResultResource;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ResultResource::collection(Result::query()->with(['student', 'exam'])->latest()->paginate(10)));
    }

    public function store(ResultRequest $request): JsonResponse
    {
        $result = Result::create($request->validated());

        return response()->json(new ResultResource($result->load(['student', 'exam'])), 201);
    }
}
