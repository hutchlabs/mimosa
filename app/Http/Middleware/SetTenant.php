<?php

namespace App\Http\Middleware;

use Closure;

use App\Gradlead\Organization;

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
        // get subdomain
        $parsedUrl =  parse_url($_SERVER['HTTP_HOST']);
        $idx = (isset($parsedUrl['path'])) ? 'path' : 'host';
        $host = explode('.', $parsedUrl[$idx]);
        $subdomain = $host[0];

        // get tenant info
        $tenant = Organization::where('subdomain','=',$subdomain)->first(); 
        $tenantId = (is_null($tenant)) ? 1 : $tenant->id;

        // set tenant 
        \Landlord::addTenant('organization_id',$tenantId);

        return $next($request);
    }
}
