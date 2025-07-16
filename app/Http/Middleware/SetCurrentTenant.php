<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionKey = 'current_tenant_id_' . $user->id;

            // Get tenant ID from header, session, or first tenant
            $tenantId = $request->header('Tenant-Id')
                ?? session($sessionKey)
                ?? $user->current_tenant_id
                ?? $user->tenants()->first()?->id;

            if ($tenantId) {
                // Verify the user has access to this tenant
                if ($user->tenants()->where('tenants.id', $tenantId)->exists()) {
                    $user->current_tenant_id = $tenantId;
                    $user->save();
                    session([$sessionKey => $tenantId]);
                } else {
                    // If no access, use first available tenant
                    $firstTenant = $user->tenants()->first();
                    if ($firstTenant) {
                        $user->current_tenant_id = $firstTenant->id;
                        $user->save();
                        session([$sessionKey => $firstTenant->id]);
                    }
                }
            }
        }

        return $next($request);
    }
}
