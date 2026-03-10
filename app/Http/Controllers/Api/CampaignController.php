<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        // Return campaigns as plain array (no data wrapper)
        return response()->json(Campaign::with('contactList')->get());
    }

    public function store(StoreCampaignRequest $request)
    {
        $campaign = Campaign::create($request->validated());
        return response()->json($campaign, 201);
    }

    public function show($id)
    {
        $campaign = Campaign::with('contactList')->findOrFail($id);
        return response()->json($campaign);
    }

    public function dispatch($id)
    {
        $campaign = Campaign::findOrFail($id);
        app(CampaignService::class)->dispatch($campaign);

        return response()->json(['message' => 'Campaign dispatched.']);
    }
}
