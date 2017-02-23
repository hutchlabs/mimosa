<?php

namespace App\Http\Middleware;

use Closure;

use App\Gradlead\Organization;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;


class SetTenant
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        $tenantId = 1;
                
        if (Auth::check()) { 
            $tenantId = Auth::user()->organization_id;
        } else {
            // get subdomain
            $parsedUrl =  parse_url($_SERVER['HTTP_HOST']);
            $idx = (isset($parsedUrl['path'])) ? 'path' : 'host';
            $host = explode('.', $parsedUrl[$idx]);
            $subdomain = $host[0];
            if ($subdomain!='app') {
                $tenant = Organization::where('subdomain','=',$subdomain)->first(); 
                $tenantId = ($tenant==null) ? 1 : $tenant->id;              
            } 
        }

        \Landlord::removeTenant('organization_id');
        \Landlord::addTenant('organization_id',$tenantId);
        
        // reload tenant classes
        \App\User::bootBelongsToTenants();
        \App\Gradlead\Event::bootBelongsToTenants();
        \App\Gradlead\Theme::bootBelongsToTenants();
        \App\Gradlead\Questionnaire::bootBelongsToTenants();
        \App\Gradlead\Contract::bootBelongsToTenants();

        return $next($request);
    }
}
