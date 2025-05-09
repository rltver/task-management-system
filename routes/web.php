<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskAttachmentController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/general', function () {
    return view('export.generalStatistics');
});

//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
Route::controller(DashboardController::class)->middleware(['auth', 'verified','throttle:50,1'])->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/reports/export/csv/userPerformance', 'userPerformanceCsv')->name('userPerformanceCsv');
    Route::get('/reports/export/pdf/userPerformance', 'userPerformancePdf')->name('userPerformancePdf');
//    Route::get('/reports/export/csv/timeBasedReport', 'timeBasedReportCsv')->name('timeBasedReportCsv');
//    Route::get('/reports/export/pdf/timeBasedReport', 'timeBasedReportPdf')->name('timeBasedReportPdf');
//    Route::get('/reports/export/csv/generalStatistics', 'generalStatisticsCsv')->name('generalStatisticsCsv');
    Route::get('/reports/export/pdf/generalStatistics', 'generalStatisticsPdf')->name('generalStatisticsPdf');
//    Route::get('/general', 'generalStatistics')->name('generalStatistics');

});


Route::controller(CategoriesController::class)->middleware(['auth', 'verified','throttle:50,1'])->group(function () {
    Route::get('/categories', 'index')->name('categories.index');
    Route::post('/categories', 'store')->name('categories.store');
    Route::patch('/categories/{category}', 'update')->name('categories.update');
    Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
    Route::post('/categories/reorder', 'reorder')->name('categories.reorder');
});

Route::controller(TaskController::class)->middleware(['auth', 'verified','throttle:50,1'])->group(function () {
    Route::get('/tasks', 'index')->name('tasks.index');
    Route::get('/tasks/deletedTasks', 'deletedTasks')->name('tasks.deletedTasks');
    Route::get('/tasks/create', 'create')->name('tasks.create');
    Route::get('/tasks/{task}', 'show')->name('tasks.show');
    Route::post('/tasks', 'store')->name('tasks.store');
    Route::get('/tasks/{task}/edit', 'edit')->name('tasks.edit');
    Route::patch('/tasks/{task}', 'update')->name('tasks.update');
    Route::delete('/tasks/{task}', 'destroy')->name('tasks.destroy');
    Route::post('/tasks/restore/{task}', 'restore')->name('tasks.restore');
    Route::delete('/tasks/forceDelete/{task}', 'forceDelete')->name('tasks.forceDelete');
    Route::post('/tasks/{task}/status', 'updateStatus')->name('tasks.updateStatus');
});

Route::controller(TaskCommentController::class)->middleware(['auth', 'verified','throttle:50,1'])->group(function () {
    Route::post('/tasks/{task}/comments', 'store')->name('comments.store');
});

Route::controller(TaskAttachmentController::class)->middleware(['auth', 'verified','throttle:50,1'])->group(function () {
    Route::post('/tasks/{task}/attachments', 'store')->name('attachments.store');
});


Route::middleware(['auth',"verified"])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
