<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ExamResource::collection(Exam::query()->with('subject')->latest()->paginate(10)));
    }

    public function store(ExamRequest $request): JsonResponse
    {
        $exam = Exam::create($request->validated());

        return response()->json(new ExamResource($exam->load('subject')), 201);
    }

    public function show(Exam $exam): JsonResponse
    {
        return response()->json(new ExamResource($exam->load('subject')));
    }

    public function update(ExamRequest $request, Exam $exam): JsonResponse
    {
        $exam->update($request->validated());

        return response()->json(new ExamResource($exam->fresh('subject')));
    }

    public function destroy(Exam $exam): JsonResponse
    {
        $exam->delete();

        return response()->json(['message' => 'Exam deleted successfully.']);
    }
}
