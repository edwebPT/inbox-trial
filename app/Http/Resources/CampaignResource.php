<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'status' => $this->status,
            'scheduled_at' => $this->scheduled_at,

            'stats' => [
                'pending' => $this->pending_count ?? 0,
                'sent' => $this->sent_count ?? 0,
                'failed' => $this->failed_count ?? 0,
            ],
        ];
    }
}
