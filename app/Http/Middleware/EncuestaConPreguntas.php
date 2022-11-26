<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Encuesta;

class EncuestaConPreguntas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $encuesta_id)
    {
		$encuesta = Encuesta::find($encuesta_id);
		dd($encuesta_id);
		if ($encuesta->preguntas->count() == 0)
			return redirect('dashboard');
        return $next($request);
    }
}
