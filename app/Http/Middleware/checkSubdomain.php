<?php

namespace App\Http\Middleware;

use App\Models\Web;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $host_parts = explode('.', $host);

        if (Web::count() == 0) {
            return redirect()->route('login')->with('showAlert', ['type' => 'danger', 'msg' => 'Web belum dibuat! Silahkan masuk sebagai Super Admin untuk membuat web.']);
        }

        if (count($host_parts) >= 3) {
            $subdomain = $host_parts[0];
            $web = Web::where('subdomain', $subdomain)->first();
            if (!$web) {
                // return abort(404);
                $web = Web::first();
            }

            $request->attributes->set('web_id', $web->id);
        }
        
        return $next($request);
    }
}
