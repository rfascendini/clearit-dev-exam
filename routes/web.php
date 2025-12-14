<?php

use Illuminate\Support\Facades\Route;

// Controllers (ajustá namespaces si los pusiste en carpetas distintas)
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\AgentTicketController;
use App\Http\Controllers\TicketDocumentController;
use App\Http\Controllers\DocumentRequestController;

/*_____________Public____________*/
Route::get('/', function () {
    return view('welcome');
})->name('home');


/*_____________Auth routes___________*/
require __DIR__ . '/auth.php'; // This file is created by Breeze for login/register/password reset, etc.

/*_____________Protected Routes_____________*/
Route::middleware(['auth'])->group(function () {


    /*_____________Dashboard_____________*/
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');


    /*_____________Profile_____________*/
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*_____________Notifications_____________*/
    Route::get('/notifications', function () {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications()->latest()->get(),
        ]);
    })->name('notifications.index');

    Route::post('/notifications/{id}/read', function (string $id) {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();
        return redirect()->route('notifications.index');
    })->name('notifications.read');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->route('notifications.index');
    })->name('notifications.readAll');

    /*_____________USER routes_____________*/
    Route::middleware(['role:user'])->group(function () {

        // Tickets
        Route::get('/tickets', [UserTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [UserTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [UserTicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [UserTicketController::class, 'show'])->name('tickets.show');

        // Upload documents for a ticket
        Route::post('/tickets/{ticket}/documents', [TicketDocumentController::class, 'store'])
            ->name('tickets.documents.store');

        // Upload documents for a document request
        Route::post('/document-requests/{documentRequest}/upload', [TicketDocumentController::class, 'uploadForRequest'])
            ->name('documentRequests.upload');
    });

    /*_____________AGENT routes_____________*/
    Route::middleware(['role:agent'])
        ->prefix('agent')
        ->name('agent.')
        ->group(function () {

            // Index of tickets
            Route::get('/tickets', [AgentTicketController::class, 'index'])->name('tickets.index');
            Route::get('/tickets/{ticket}', [AgentTicketController::class, 'show'])->name('tickets.show');

            // Change the status of a ticket
            Route::post('/tickets/{ticket}/status', [AgentTicketController::class, 'setStatus'])
                ->name('tickets.setStatus');

            // Create a document request for a ticket
            Route::post('/tickets/{ticket}/document-requests', [DocumentRequestController::class, 'store'])
                ->name('documentRequests.store');

            // (Opcional) aprobar / rechazar un request (útil para cerrar el flujo)
            Route::post('/document-requests/{documentRequest}/approve', [DocumentRequestController::class, 'approve'])
                ->name('documentRequests.approve');

            Route::post('/document-requests/{documentRequest}/reject', [DocumentRequestController::class, 'reject'])
                ->name('documentRequests.reject');
        });
});
