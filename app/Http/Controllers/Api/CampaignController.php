<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Services\CampaignService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Resources\CampaignResource;

class CampaignController extends Controller
{

    public function index()
    {
        $campaigns = Campaign::withCount([
            'sends as pending_count' => fn($q)=>$q->where('status','pending'),
            'sends as sent_count' => fn($q)=>$q->where('status','sent'),
            'sends as failed_count' => fn($q)=>$q->where('status','failed'),
        ])->paginate(15);

        return CampaignResource::collection($campaigns);
    }

    public function store(StoreCampaignRequest $request, CampaignService $service)
    {
        $campaign = $service->create($request->validated());

        return new CampaignResource($campaign);
    }

    public function show($id)
    {
        $campaign = Campaign::withCount([
            'sends as pending_count' => fn($q)=>$q->where('status','pending'),
            'sends as sent_count' => fn($q)=>$q->where('status','sent'),
            'sends as failed_count' => fn($q)=>$q->where('status','failed'),
        ])->findOrFail($id);

        return new CampaignResource($campaign);
    }

    public function dispatch($id, CampaignService $service)
    {
        $campaign = Campaign::with('contactList.contacts')->findOrFail($id);

        $service->dispatch($campaign);

        return response()->json([
            'message' => 'Campaign dispatched'
        ]);
    }
}
