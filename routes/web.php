<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Play;
use App\Http\Livewire\Preguntas;
use App\Http\Livewire\InsertaPregunta;
use App\Http\Livewire\EditaEncuesta;
use App\Http\Livewire\Lanza;
use App\Http\Livewire\Participa;
use App\Http\Livewire\PreguntaLanzada;
use App\Http\Livewire\Misrespuestas;
use App\Http\Livewire\LanzamientoManual;
use App\Http\Livewire\Invitar;
use App\Http\Livewire\PlayProgramado;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('play/{publica}/{participante_id}',Play::class)->name('play'); 
Route::get('play-programado/{publica}/{participante_id}',PlayProgramado::class)->name('play-programado');
Route::get('preguntas/{encuesta_id}',Preguntas::class)->name('preguntas'); 
Route::get('editaencuesta/{id}',EditaEncuesta::class)->name('editaencuesta'); 
Route::get('lanza/{encuesta_id}',Lanza::class)->name('lanza');
Route::get('pregunta-lanzada/{publica_id}/{forma}',PreguntaLanzada::class)->name('pregunta-lanzada'); 
Route::get('misrespuestas/{publica_id}/{participante_id}',Misrespuestas::class)->name('misrespuestas'); 
Route::get('lanzamiento-manual',LanzamientoManual::class)->name('lanzamiento-manual');
Route::get('participa/{token}',Participa::class)->name('participa');
Route::get('inserta-pregunta/{encuesta}/{tipo}',InsertaPregunta::class)->name('inserta-pregunta'); 
Route::get('invitar',Invitar::class)->name('invitar');