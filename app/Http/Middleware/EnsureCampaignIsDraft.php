<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Campaign;

class EnsureCampaignIsDraft
{
    public function handle(Request $request, Closure $next)
    {
        $campaign = Campaign::findOrFail($request->route('id'));

        if ($campaign->status !== 'draft') {
            return response()->json([
                'error' => 'Campaign must be in draft status.'
            ], 422);
        }

        return $next($request);
    }
}
