<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\PdfReportController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\AnnouncementController as StudentAnnouncementController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showStudentRegister'])->name('student.register');
Route::post('/register', [AuthController::class, 'studentRegister'])->name('student.register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student Routes
Route::middleware(['student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [StudentProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [StudentProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [StudentProfileController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [StudentProfileController::class, 'changePassword'])->name('change-password.submit');

    // Grades Routes
    Route::get('/grades', [StudentGradeController::class, 'grades'])->name('grades');
    Route::get('/grades/download', [StudentGradeController::class, 'downloadGrades'])->name('grades.download');

    // Announcements Routes
    Route::get('/announcements', [StudentAnnouncementController::class, 'announcements'])->name('announcements');
});

// Admin Routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Student Management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.delete');
    Route::post('/students/{student}/reset-password', [AdminStudentController::class, 'resetPassword'])->name('students.reset-password');

    // Grade Management
    Route::get('/grades', [AdminGradeController::class, 'index'])->name('grades.index');
    Route::post('/grades', [AdminGradeController::class, 'store'])->name('grades.store');
    Route::put('/grades/{grade}', [AdminGradeController::class, 'update'])->name('grades.update');
    Route::delete('/grades/{grade}', [AdminGradeController::class, 'destroy'])->name('grades.delete');
    Route::get('/grades/summary/download', [AdminGradeController::class, 'downloadGradeSummary'])->name('grades.summary.download');
    Route::get('/grades/transcript/{studentId}', [AdminGradeController::class, 'downloadStudentTranscript'])->name('grades.transcript.download');

    // Announcements
    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.delete');
    Route::post('/announcements/{announcement}/toggle-status', [AdminAnnouncementController::class, 'toggleStatus'])->name('announcements.toggle-status');

    // Reports
    Route::get('/reports/students', [AdminReportController::class, 'studentList'])->name('reports.students');
    Route::post('/reports/students/generate', [AdminReportController::class, 'generateStudentList'])->name('reports.students.generate');
    Route::get('/reports/grades', [AdminReportController::class, 'gradeReports'])->name('reports.grades');

    // PDF Reports
    Route::get('/reports/student-list/download', [PdfReportController::class, 'generateStudentListReport'])->name('reports.student-list.download');
    Route::get('/reports/student-grades/{studentId}/download', [PdfReportController::class, 'generateStudentGradesReport'])->name('reports.student-grades.download');
    Route::get('/reports/grade-summary/download', [PdfReportController::class, 'generateGradeSummaryReport'])->name('reports.grade-summary.download');

    // Activity Logs
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{activityLog}', [AdminActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/activity-logs/{activityLog}', [AdminActivityLogController::class, 'destroy'])->name('activity-logs.delete');
    Route::delete('/activity-logs/clear/old', [AdminActivityLogController::class, 'clearOldLogs'])->name('activity-logs.clear-old');
});
