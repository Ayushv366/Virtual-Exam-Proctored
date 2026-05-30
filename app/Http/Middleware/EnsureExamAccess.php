<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class EnsureExamAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $exam = $request->route('exam');

        if ($exam && method_exists($exam, 'is_active')) {
            if (! $exam->is_active || Carbon::now()->lt($exam->start_time) || Carbon::now()->gt($exam->end_time)) {
                abort(403, 'The virtual exam hall is not available for this exam.');
            }
        }

        return $next($request);
    }
}
