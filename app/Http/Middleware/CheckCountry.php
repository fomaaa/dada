<?php

namespace App\Http\Middleware;

use Closure;

class CheckCountry
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
      $url = $request->getRequestUri();

      // Если админка
      if (strpos($url, '/admin') === 0) {
        return $next($request);
      }

      // Check current country from header
      $language = mb_strtolower($request->header('X-GeoIP-Country-Code', 'RU'));
      if($language == 'us') {
        $language = 'en';
      }
      if($language !== 'ru' && $language !== 'en') {
        $language = 'en';
      }

      $urlLanguage = mb_strtolower($request->segment(1));

      // редиректим без языка в урле
      if($urlLanguage !== 'ru' && $urlLanguage !== 'en') {
        return redirect('/'.$language.$url);
      } else {
        $url = substr($url, 3);
      }

      // редиректим если пришли на другую языковую версию
      if($urlLanguage !== $language) {
        return redirect('/'.$language.$url);
      }

      app()->setLocale($language);

      return $next($request);
    }
}
