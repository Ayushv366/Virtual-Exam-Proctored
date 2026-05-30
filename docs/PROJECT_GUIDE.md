# Virtual Exam Hall with Proctoring Features

## Exact Commands

Run these from the project folder:

```powershell
cd C:\path\to\ExamProctorProject-main\ExamProctorProject-main
composer install --ignore-platform-req=ext-mongodb
npm.cmd install
Copy-Item .env.example .env -Force
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm.cmd run build
php artisan serve --host=127.0.0.1 --port=8000
```

If Composer is not globally installed:

```powershell
Invoke-WebRequest -Uri https://getcomposer.org/installer -OutFile composer-setup.php
php composer-setup.php --install-dir=. --filename=composer.phar
php composer.phar install --ignore-platform-req=ext-mongodb
```

## .env Configuration

```env
APP_NAME="Virtual Exam Hall"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
MAIL_MAILER=log
MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=virtual_exam_hall
```

## MongoDB Setup

Install MongoDB Community Server, start it locally, and keep:

```env
MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=virtual_exam_hall
```

Camera snapshots use `App\Models\CameraLog`, connection `mongodb`, collection `camera_logs`. If MongoDB is unavailable, image files are still stored locally and the app does not crash.

## URLs

- App: `http://127.0.0.1:8000`
- Exams API: `http://127.0.0.1:8000/api/exams`
- Results API: `http://127.0.0.1:8000/api/results`
- Legacy API prefix also works: `http://127.0.0.1:8000/api/v1/exams`

## Sample Credentials

- Admin: `admin@vexam.test` / `password`
- Faculty: seeded random faculty emails / `password`
- Student: seeded random student emails / `password`

Use `php artisan tinker` and `App\Models\User::pluck('email','role')` to list generated emails.

## Postman API Testing

GET exams:

```http
GET http://127.0.0.1:8000/api/exams
Accept: application/json
```

POST exam:

```http
POST http://127.0.0.1:8000/api/exams
Accept: application/json
Content-Type: application/json

{
  "subject_id": 1,
  "faculty_id": 2,
  "title": "Operating Systems Quiz",
  "instructions": "Remain in fullscreen mode.",
  "start_time": "2026-06-01 10:00:00",
  "end_time": "2026-06-01 11:00:00",
  "duration_minutes": 60,
  "total_marks": 100,
  "passing_marks": 40,
  "room_code": "OS101",
  "is_active": true
}
```

PUT exam:

```http
PUT http://127.0.0.1:8000/api/exams/1
Accept: application/json
Content-Type: application/json
```

DELETE exam:

```http
DELETE http://127.0.0.1:8000/api/exams/1
Accept: application/json
```

GET results:

```http
GET http://127.0.0.1:8000/api/results
Accept: application/json
```

## Syllabus Mapping

Unit I:
- MVC: `app/Models`, `app/Http/Controllers`, `resources/views`
- Composer: `composer.json`, `composer.lock`
- Artisan: migrations, seeders, route list, serve commands

Unit II:
- Basic routing: `routes/web.php`
- Route parameters: `/student/exam-hall/{exam}`
- Views and passing data: dashboard and exam views
- Shared view data: `AppServiceProvider`
- Response headers: `/headers-demo`
- Cookies: locale cookie and visited exam hall cookie
- JSON responses: `routes/api.php`
- Redirects and named routes: auth and dashboard redirects

Unit III:
- Controllers: Admin, Faculty, Student, Exam, Question, Proctoring
- Middleware: `RoleMiddleware`, `SetLocale`, `EnsureExamAccess`
- Resource controllers: `Route::resource('exams')`, `Route::resource('questions')`
- Blade inheritance: `resources/views/layouts/master.blade.php`
- Route groups, prefixes, constraints: admin/faculty/student groups
- Domain routing demo: `exam.localhost`
- URL helpers: `route(...)` throughout Blade

Unit IV:
- Request data: controllers use `$request->input()`, `$request->file()`
- Old input: forms use `old(...)`
- File upload: student profile image and webcam snapshots
- Cookies: locale switch
- Email: exam registration, exam reminder, result notification
- Localization: `lang/en/messages.php`, `lang/hi/messages.php`
- Session: active exam id, exam start time, violation count

Unit V:
- CSRF: all forms include `@csrf`
- Method fields: `@method('PUT')`, `@method('PATCH')`
- Validation: FormRequest classes
- Custom messages: `ExamRequest`, `QuestionRequest`
- Custom rule: `ExamStartTimeNotPast`
- Repopulation: `old(...)` in forms

Unit VI:
- Migrations/models: users, subjects, exams, questions, student_exams, results, proctor_logs, announcements
- Query Builder: Admin reports and user management
- Eloquent CRUD: exams, questions, subjects, announcements
- Seeders/factories: `database/seeders`, `database/factories`
- Pagination: dashboards and index pages
- Relationships: User exams/results/logs, Exam questions/students/results, Result student/exam

## SQL Schema

```sql
users(id, name, email, role, profile_image, status, last_login_at, email_verified_at, password, remember_token, created_at, updated_at)
subjects(id, name, code, description, is_active, created_at, updated_at)
exams(id, subject_id, faculty_id, title, instructions, start_time, end_time, duration_minutes, total_marks, passing_marks, room_code, is_active, published_at, created_at, updated_at)
questions(id, exam_id, question_type, question_text, options, correct_answer, marks, sequence, created_at, updated_at)
student_exams(id, student_id, exam_id, started_at, submitted_at, score, status, attempt_data, created_at, updated_at)
results(id, student_id, exam_id, obtained_marks, total_marks, percentage, status, remarks, published_at, created_at, updated_at)
proctor_logs(id, student_id, exam_id, violation_type, description, timestamp, created_at, updated_at)
announcements(id, title, message, audience, publish_at, is_active, created_by, created_at, updated_at)
```

## Project Tree

```text
app/
  Http/Controllers/
  Http/Middleware/
  Http/Requests/
  Http/Resources/
  Mail/
  Models/
  Rules/
database/
  migrations/
  seeders/
  factories/
resources/views/
  layouts/master.blade.php
  auth/
  admin/
  faculty/
  student/
  exams/
  questions/
  subjects/
  announcements/
  proctoring/
  emails/
routes/
  web.php
  api.php
lang/
  en/messages.php
  hi/messages.php
docs/
  PROJECT_GUIDE.md
```

## Testing Checklist

```powershell
php artisan route:list
php artisan migrate:fresh --seed
npm.cmd run build
php artisan test
```

Manual checks:

1. Login as admin and create an exam.
2. Login as faculty and add MCQ/subjective questions.
3. Login as student and join an active exam hall.
4. Switch tabs, exit fullscreen, right click, and press F12 to create proctor logs.
5. Submit exam and verify result email is written to `storage/logs/laravel.log`.
