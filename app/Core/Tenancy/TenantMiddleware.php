<?php

namespace App\Core\Tenancy;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that resolves and sets the current tenant from the authenticated user.
 */
class TenantMiddleware
{
    public function __construct(private readonly TenantContext $context) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = $request->user();

        if ($user && $user->tenant_id) {
            $tenant = $user->tenant()->withoutTenantScope()->first();

            if ($tenant) {
                $this->context->set($tenant);
            }
        }

        return $next($request);
    }
}
