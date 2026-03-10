<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignSend;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCampaignsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Campaign $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all active contacts for the campaign's contact list
        $contacts = $this->campaign->contactList
            ->contacts()
            ->where('status', 'active')
            ->get();

        foreach ($contacts as $contact) {
            try {
                // Send email (replace with your mailable)
                Mail::raw($this->campaign->body, function ($message) use ($contact) {
                    $message->to($contact->email)
                        ->subject('Campaign: ' . $this->campaign->subject);
                });

                // Record as sent
                CampaignSend::create([
                    'campaign_id' => $this->campaign->id,
                    'contact_id' => $contact->id,
                    'status' => 'sent',
                ]);
            } catch (\Exception $e) {
                // Record as failed
                CampaignSend::create([
                    'campaign_id' => $this->campaign->id,
                    'contact_id' => $contact->id,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }

        // Update campaign status
        $this->campaign->update(['status' => 'sent']);
    }
}
