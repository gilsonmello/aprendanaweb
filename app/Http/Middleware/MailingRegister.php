<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class MailingRegister
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
        //Se houver parâmetros, email e campanha
       if (count($request->all()) > 0 && isset($request->all()['email']) && isset($request->all()['campaign_id']))  {
           //Verifico se existi registro do usuário naquela campanha específica
           //Se não existir, insiro um novo registro
          try{ 
              $query = \App\MailingRegister::where('email', '=', $request->all()['email'])
                      ->where('campaign_id', '=', $request->all()['campaign_id'])
                      ->get()
                      ->isEmpty();
              if($query){
                $mailingRegister = new \App\MailingRegister;
                $mailingRegister->email = $request->all()['email'];
                $mailingRegister->campaign_id = $request->all()['campaign_id'];
                $mailingRegister->save();
              }
          }catch(Exception $e){
                
          }
        }
        return $next($request);
    }
}
