<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLang
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
        $url=$request->getRequestUri();
        // Если админка
        if (strpos($url, '/admin') === 0) {
            return $next($request);
        }
        else
        if($url=='/')
        {
            return $next($request);
        }
        $response = $next($request);

        if(isset($response->original->lang))
        {

            $lang=$response->original->lang;
        }
        else
        {
            return redirect('/ru'.$url);
        }

        if(($lang == 'ru') ||  ($lang =='en'))
        {
            return $next($request);
        }
        else
        {
            $url=str_replace($request->lang, 'ru', $url);
            return redirect($url);
        }
    }
}
