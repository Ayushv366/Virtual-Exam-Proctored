<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProctoringController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| MVC note for viva: routes receive the HTTP request, controllers perform the
| application logic, models talk to the database, and Blade views render HTML.
*/

Route::middleware('locale')->group(function (): void {
    Route::get('/', function () {
        return redirect()->route('login')
            ->withCookie(cookie('visited_exam_hall', 'yes', 60 * 24))
            ->withHeaders(['X-Project-Module' => 'Virtual Exam Hall']);
    })->name('home');

    Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
        ->whereIn('locale', ['en', 'hi'])
        ->name('locale.switch');

    Route::middleware('guest')->group(function (): void {
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.store');
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware('auth')->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/headers-demo', fn () => response('Laravel response header demonstration', Response::HTTP_OK)
            ->header('X-Syllabus-Topic', 'Responses and headers'))->name('headers.demo');

        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function (): void {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/students', [AdminController::class, 'manageStudents'])->name('students.index');
            Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
            Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
            Route::get('/students/{user}/edit', [AdminController::class, 'editStudent'])->whereNumber('user')->name('students.edit');
            Route::put('/students/{user}', [AdminController::class, 'updateStudent'])->whereNumber('user')->name('students.update');
            Route::get('/faculty', [AdminController::class, 'manageFaculty'])->name('faculty.index');
            Route::get('/faculty/create', [AdminController::class, 'createFaculty'])->name('faculty.create');
            Route::post('/faculty', [AdminController::class, 'storeFaculty'])->name('faculty.store');
            Route::get('/faculty/{user}/edit', [AdminController::class, 'editFaculty'])->whereNumber('user')->name('faculty.edit');
            Route::put('/faculty/{user}', [AdminController::class, 'updateFaculty'])->whereNumber('user')->name('faculty.update');
            Route::get('/subjects', [AdminController::class, 'manageSubjects'])->name('subjects.index');
            Route::post('/subjects', [AdminController::class, 'storeSubject'])->name('subjects.store');
            Route::get('/exams', [AdminController::class, 'exams'])->name('exams.index');
            Route::get('/exams/create', [AdminController::class, 'createExam'])->name('exams.create');
            Route::post('/exams', [AdminController::class, 'storeExam'])->name('exams.store');
            Route::patch('/exams/{exam}/toggle', [AdminController::class, 'toggleExam'])->whereNumber('exam')->name('exams.toggle');
            Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
            Route::get('/suspicious-activity', [AdminController::class, 'suspiciousActivity'])->name('suspicious');
            Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
            Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
        });

        Route::middleware('role:faculty')->prefix('faculty')->name('faculty.')->group(function (): void {
            Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard');
            Route::get('/questions', [FacultyController::class, 'questionBanks'])->name('questions');
            Route::get('/questions/create', [FacultyController::class, 'createQuestion'])->name('questions.create');
            Route::post('/questions', [FacultyController::class, 'storeQuestion'])->name('questions.store');
            Route::get('/assign-exams', [FacultyController::class, 'assignExams'])->name('assign-exams');
            Route::get('/attempts', [FacultyController::class, 'monitorAttempts'])->name('attempts');
            Route::get('/reports', [FacultyController::class, 'reports'])->name('reports');
        });

        Route::middleware('role:student')->prefix('student')->name('student.')->group(function (): void {
            Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
            Route::post('/profile-image', [StudentController::class, 'profileImage'])->name('profile.image');
            Route::get('/history', [StudentController::class, 'history'])->name('history');
            Route::get('/results', [StudentController::class, 'results'])->name('results');
            Route::post('/exams/{exam}/remind', [StudentController::class, 'remind'])->whereNumber('exam')->name('exams.remind');
            Route::get('/exam-hall/{exam}', [StudentController::class, 'joinHall'])->whereNumber('exam')->name('hall');
            Route::post('/exam-hall/{exam}/submit', [StudentController::class, 'submitExam'])->whereNumber('exam')->name('exam.submit');
        });

        Route::resource('exams', ExamController::class)->where(['exam' => '[0-9]+']);
        Route::resource('questions', QuestionController::class)->where(['question' => '[0-9]+']);

        Route::get('/proctoring/logs', [ProctoringController::class, 'index'])->name('proctoring.logs');
        Route::post('/proctoring/violations', [ProctoringController::class, 'storeViolation'])->name('proctoring.violation');
        Route::post('/proctoring/snapshots', [ProctoringController::class, 'captureSnapshot'])->name('proctoring.snapshot');
        Route::patch('/proctoring/snapshots/{cameraLog}', [ProctoringController::class, 'updateSnapshot'])->name('proctoring.snapshot.update');
        Route::delete('/proctoring/snapshots/{cameraLog}', [ProctoringController::class, 'destroySnapshot'])->name('proctoring.snapshot.destroy');
    });
});

/*
| Domain routing demonstration for Unit III. It is optional at runtime because
| most college laptops use localhost, but the route shows Laravel's domain API.
*/
Route::domain('exam.localhost')->get('/domain-demo', fn () => 'Domain route demo')->name('domain.demo');
