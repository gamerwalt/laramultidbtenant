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
        $tenantDatabase = Auth::user()->tenantUser->tenant->tenantDatabase;

        $this->resolveDatabase($tenantDatabase);

        return $next($request);
    }
} 