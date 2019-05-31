<?php 

namespace gamerwalt\LaraMultiDbTenant;

use Closure;
use gamerwalt\LaraMultiDbTenant\Traits\TenantConnector;
use Auth;

class AuthTenant
{
    use TenantConnector;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tenantUsers = Auth::user()->tenantUser()->get();

        if($tenantUsers->count() > 1)
        {
            if(session('selected-tenant') === null)
            {
                return redirect('/tenants/select');
            }

            foreach($tenantUsers as $tenantUser) {
                if($tenantUser->tenant->tenant_uid === session('selected-tenant')) {
                    $tenantDatabase = $tenantUser->tenant->tenantDatabase()->first();
                }
            }

            $this->resolveDatabase($tenantDatabase);
    
            return $next($request);
        }

        $tenantDatabase = Auth::user()->tenantUser->tenant->tenantDatabase;
        
        $this->resolveDatabase($tenantDatabase);

        return $next($request);
    }
} 