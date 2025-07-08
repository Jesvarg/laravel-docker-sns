<?php
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::post('/submit', [FormController::class, 'submit']);

Route::get('/', function () {
    return view('submit');
});
