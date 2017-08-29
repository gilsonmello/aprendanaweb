<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Cart\CartService;

class OriginExternal
{   
    /**
     *
     * @param  CartService $cartService
     */
    public function __construct(CartService $cartService){
        //Objeto que irá conter as funções do carrinho
        $this->cartService = $cartService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('utm_source')){

            $origin = new \App\OriginExternal;
            $origin->slug = $request->path();
            $origin->source = $request->input('utm_source');
            $origin->medium = $request->input('utm_medium');
            $origin->campaign = $request->input('utm_campaign');
            $origin->save();

            session(['origin_external' => $origin]);

        }
        //Se o usuário veio do compliance e estiver tentando acessar outra URL que não possua carrinho
        //Mudo o valor para falso e deleto os itens do carrinho
        //Se estiver acessando o carrinho e veio do compliance, a sessão continua TRUE
        //dd($_SERVER);
        $urls = [
            '/carrinho/autenticacao',
            '/carrinho/pagamento',
            '/auth/login',
            '/pagseguro/send',
            '/carrinho/boleto-emitido',
            '/carrinho/conclusao'
        ];

        //Condicional para saber se o usuário veio da rota /compliance
        /*session_start();
        if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'compliance') > 0){
            $_SESSION['compliance']['cart'] = true;
            session(['compliance.cart' => true]);
        }
        if(in_array($_SERVER['REQUEST_URI'], $urls) === FALSE && $_SESSION['compliance']['cart'] === TRUE){
            session(['compliance.cart' => FALSE]);
            $this->cartService->destroy();
            //dd($_SERVER['REQUEST_URI'], in_array($_SERVER['REQUEST_URI'], $urls), session('compliance.cart'));
        }*/
        /*if(strpos($_SERVER['REQUEST_URI'], 'carrinho') === FALSE && session('compliance.cart') === TRUE){
            if(strpos($_SERVER['REQUEST_URI'], 'pagseguro') > 0 || strpos($_SERVER['REQUEST_URI'], 'auth') > 0){
                
            }else{
                session(['compliance.cart' => FALSE]);
                $this->cartService->destroy();
            }
        }*/

        return $next($request);
    }
}
