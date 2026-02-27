<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberBadgeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:admin,manager,employee')->group(function () {
        Route::resource('members', MemberController::class);
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('payments', PaymentController::class);
        Route::get('/members/{member}/badge', [MemberBadgeController::class, 'show'])->name('members.badge');
        Route::get('/attendance/checkin/{member}', [AttendanceLogController::class, 'checkInByQr'])
            ->middleware('signed')
            ->name('attendance.checkin.qr');
    });

    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/reports/financial', [FinancialReportController::class, 'index'])->name('reports.financial');
        Route::get('/reports/financial/pdf', [FinancialReportController::class, 'exportPdf'])->name('reports.financial.pdf');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
