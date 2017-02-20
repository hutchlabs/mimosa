<?php

namespace App\Http\Middleware;

use Closure;

use App\Gradlead\Organization;
use App\User;
use Illuminate\Support\Facades\Auth;

class SetTenant
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
        if (Auth::check()) { 
            $tenantId = Auth::user()->organization_id;
            exit($tentantId);
            \Landlord::addTenant('organization_id',$tenantId);
        } else {
            // get subdomain
            $parsedUrl =  parse_url($_SERVER['HTTP_HOST']);
            $idx = (isset($parsedUrl['path'])) ? 'path' : 'host';
            $host = explode('.', $parsedUrl[$idx]);
            $subdomain = $host[0];
            if ($subdomain!='localhost') {
                $tenant = Organization::where('subdomain','=',$subdomain)->first(); 
                $tenantId = (is_null($tenant)) ? 1 : $tenant->id; 
                \Landlord::addTenant('organization_id',$tenantId);
            }
        }

        return $next($request);
    }
}
