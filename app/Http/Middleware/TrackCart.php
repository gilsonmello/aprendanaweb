<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class TrackCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((strpos($request->path(), 'carrinho/add') !== false) ||
            ($request->path() === 'carrinho/autenticacao') ||
            ($request->path() === 'carrinho/pagamento') ||
            ($request->path() === 'carrinho/completa-cadastro') ||
            ($request->path() === 'carrinho/conclusao') ||
            ($request->path() === 'carrinho/boleto-emitido')  ||
            ($request->path() === 'pagseguro/send')) {

            $track = new \App\TrackCart;
            $track->path = $request->path();
            $track->user_id = (auth()->check()) ? auth()->user()->id : null;
            $track->session = Session::getId();
            $track->ip = Request::ip();
            $track->order_id = session('order_id_in_session');
            $track->save();
        }

        return $next($request);
    }
}
