<?php

use App\Http\Controllers\Backend\ArtistController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\GenreController;
use App\Http\Controllers\Backend\VenueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return view('auth.login');
});


Route::get('/', function () {
    return view('backend.dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/admin-genre', [GenreController::class, 'index'])->name('genre');
    Route::post('/add-genre', [GenreController::class, 'addGenre']);
    Route::get('/fetch-genre', [GenreController::class, 'fetchGenre']);
    Route::post('/edit-genre', [GenreController::class, 'editGenre']);
    Route::post('/update-genre', [GenreController::class, 'updateGenre']);
    Route::post('/delete-genre', [GenreController::class, 'deleteGenre']);

    Route::get('/admin-artist', [ArtistController::class, 'index'])->name('artist');
    Route::post('/add-artist', [ArtistController::class, 'addArtist']);
    Route::get('/fetch-artist', [ArtistController::class, 'fetchArtist']);
    Route::post('/edit-artist', [ArtistController::class, 'editArtist']);
    Route::post('/update-artist', [ArtistController::class, 'updateArtist']);
    Route::post('/delete-artist', [ArtistController::class, 'deleteArtist']);

    Route::get('/admin-venue', [VenueController::class, 'index'])->name('venue');
    Route::post('/add-venue', [VenueController::class, 'addVenue']);
    Route::get('/fetch-venue', [VenueController::class, 'fetchVenue']);
    Route::post('/edit-venue', [VenueController::class, 'editVenue']);
    Route::post('/update-venue', [VenueController::class, 'updateVenue']);
    Route::post('/delete-venue', [VenueController::class, 'deleteVenue']);

    Route::get('/admin-event', [EventController::class, 'index'])->name('event');
    Route::post('/add-event', [EventController::class, 'addEvent']);
    Route::get('/fetch-event', [EventController::class, 'fetchEvent']);
    Route::post('/edit-event', [EventController::class, 'editEvent']);
    Route::post('/update-event', [EventController::class, 'updateEvent']);
    Route::post('/delete-event', [EventController::class, 'deleteEvent']);
});
