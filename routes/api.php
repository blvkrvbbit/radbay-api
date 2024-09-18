<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ads', [AdController::class, 'getAll']);
Route::get('/ads/{id}', [AdController::class, 'getOneById']);
Route::put('/ads/{id}', [AdController::class, 'update']);
Route::delete('/ads/{id}', [AdController::class, 'delete']);
Route::post('/ads', [AdController::class, 'create'])->middleware('auth:sanctum');
Route::get(
    '/my-ads',
    [AdController::class, 'getAllByUserId']
)->middleware('auth:sanctum');


Route::get('/categories', [CategoryController::class, 'getAll']);

Route::post('/upload', function (Request $request) {
    /**
     * Upload Images
     */
    try {
        if ($request->hasFile('files')) {
            $paths = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads', 'public');
                array_push($paths, $path);
            }
            return [
                'message' => 'added images',
                'paths' => $paths
            ];
        }
    } catch (\throwable $th) {
        return $th;
    }
})->middleware('auth:sanctum');

