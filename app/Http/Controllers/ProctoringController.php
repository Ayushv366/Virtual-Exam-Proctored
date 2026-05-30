<?php

namespace App\Http\Controllers;

use App\Models\CameraLog;
use App\Models\Exam;
use App\Models\ProctorLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class ProctoringController extends Controller
{
    public function index(Request $request): View
    {
        try {
            $cameraLogs = CameraLog::query()->where('student_id', $request->user()->id)->latest()->paginate(10);
        } catch (Throwable) {
            $cameraLogs = collect();
        }

        return view('proctoring.logs', [
            'cameraLogs' => $cameraLogs,
            'violations' => ProctorLog::query()->where('student_id', $request->user()->id)->latest()->paginate(10),
        ]);
    }

    public function storeViolation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'violation_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $log = ProctorLog::create($data + ['timestamp' => now()]);

        $count = (int) session('violation_count', 0) + 1;
        session(['violation_count' => $count]);

        return response()->json([
            'message' => 'Violation recorded.',
            'warning' => $count >= 3 ? 'Multiple violations detected. The examiner should review this session.' : 'Warning recorded.',
            'violation_count' => $count,
            'log' => $log,
        ], 201);
    }

    public function captureSnapshot(Request $request): JsonResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('image')->store('camera-snaps', 'public');

        try {
            $cameraLog = CameraLog::create([
                'student_id' => $data['student_id'],
                'image_path' => $path,
                'captured_at' => now(),
                'meta' => ['exam_id' => $data['exam_id']],
            ]);
        } catch (Throwable) {
            $cameraLog = ['image_path' => $path, 'mongodb' => 'unavailable'];
        }

        return response()->json([
            'message' => 'Camera snapshot stored.',
            'camera_log' => $cameraLog,
        ], 201);
    }

    public function updateSnapshot(Request $request, CameraLog $cameraLog): JsonResponse
    {
        $data = $request->validate([
            'meta' => ['nullable', 'array'],
        ]);

        $cameraLog->update($data);

        return response()->json(['message' => 'Camera log updated.', 'camera_log' => $cameraLog]);
    }

    public function destroySnapshot(CameraLog $cameraLog): RedirectResponse
    {
        if ($cameraLog->image_path) {
            Storage::disk('public')->delete($cameraLog->image_path);
        }

        $cameraLog->delete();

        return back()->with('success', 'Camera snapshot log deleted.');
    }
}
