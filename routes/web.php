<?php

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

Route::get('/', 'AppController@index');
Route::get('/works', 'AppController@works');
Route::get('/agency', 'AppController@agency');
Route::get('/{lang}/works', 'AppController@works');
Route::get('/{lang}/agency', 'AppController@agency');
Route::get('/{lang}', 'AppController@index');
Route::get('/{lang}/{case}', 'AppController@cases');


Route::get('ru/storage/{name}', function ($name) {
    $path = storage_path($name);
    $mime = \File::mimeType($path);
    //return Image::make($path)->Response();
    header('Content-Type: '. $mime);
    return readFile($path);
})->where('name', '(.*)');

Route::get('en/storage/{name}', function ($name) {
    $path = storage_path($name);
    $mime = \File::mimeType($path);
    //return Image::make($path)->Response();
    header('Content-Type: '. $mime);
    return readFile($path);
})->where('name', '(.*)');

Route::get('/storage/{name}', function ($name) {
    $path = storage_path($name);
    $mime = \File::mimeType($path);
    header('Content-Type: '. $mime);
    return readFile($path);
})->where('name', '(.*)');

