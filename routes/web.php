<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\ProfileController;

// Organizer Controllers
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\KajianController as OrganizerKajianController;
use App\Http\Controllers\Organizer\ParticipantController as OrganizerParticipantController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KajianController as AdminKajianController;
use App\Http\Controllers\Admin\OrganizerController as AdminOrganizerController;
use App\Http\Controllers\Admin\SpeakerController as AdminSpeakerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MosqueController as AdminMosqueController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\Auth\SocialiteController;

// OAuth Routes

Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// Public & User Routes

Route::get('/', [HomeController::class, 'index']);

Route::get('/kajian', [KajianController::class, 'index'])->name('kajian.index');
Route::get('/kajian/{kajian:slug}', [KajianController::class, 'show'])->name('kajian.show');

Route::middleware('auth')->group(function () {
    Route::post('/kajian/{kajian}/join', [AttendanceController::class, 'store']);
    Route::delete('/kajian/{kajian}/join', [AttendanceController::class, 'destroy']);
    Route::post('/kajian/{kajian}/favorite', [FavoriteController::class, 'toggle']);
    
    Route::get('/kajian-saya', [AttendanceController::class, 'index']);
    Route::get('/tersimpan', [FavoriteController::class, 'index']);
    
    Route::get('/checkin/{uuid}', [CheckinController::class, 'store']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Organizer Routes
Route::prefix('organizer')->middleware(['auth', 'role:organizer'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\Organizer\ProfileController::class, 'edit'])->name('organizer.profile.edit');
    Route::put('/profile', [App\Http\Controllers\Organizer\ProfileController::class, 'update'])->name('organizer.profile.update');

    Route::middleware('verified.organizer')->group(function () {
        Route::get('/', [OrganizerDashboardController::class, 'index'])->name('organizer.dashboard');
        
        Route::resource('kajian', OrganizerKajianController::class)->names('organizer.kajian');
        Route::get('/kajian/{kajian}/peserta', [OrganizerParticipantController::class, 'index'])->name('organizer.kajian.peserta');
        
        Route::get('/peserta', [\App\Http\Controllers\Organizer\ParticipantController::class, 'globalIndex'])->name('organizer.peserta.global');
        Route::get('/peserta/export', [\App\Http\Controllers\Organizer\ParticipantController::class, 'exportGlobal'])->name('organizer.peserta.export');
    });
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('category', AdminCategoryController::class)->names('admin.category');
    Route::resource('mosque', AdminMosqueController::class)->names('admin.mosque');
    Route::resource('speaker', AdminSpeakerController::class)->names('admin.speaker');
    Route::resource('kajian', AdminKajianController::class)->names('admin.kajian');
    Route::post('kajian/{kajian}/verify', [AdminKajianController::class, 'verify'])->name('admin.kajian.verify');
    Route::post('kajian/{kajian}/reject', [AdminKajianController::class, 'reject'])->name('admin.kajian.reject');
    
    Route::resource('organizer', AdminOrganizerController::class)->names('admin.organizer');
    Route::post('organizer/{organizer}/verify', [AdminOrganizerController::class, 'verify'])->name('admin.organizer.verify');
    
    Route::resource('user', AdminUserController::class)->names('admin.user');
});

require __DIR__.'/auth.php';
