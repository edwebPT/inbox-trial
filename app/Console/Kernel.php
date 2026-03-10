<?php
use App\Models\Campaign;
use App\Jobs\SendCampaignsEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $campaigns = Campaign::where('status', 'draft')
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '<=', now())
                ->get();

            foreach ($campaigns as $campaign) {
                $campaign->update(['status' => 'sending']);
                SendCampaignsEmail::dispatch($campaign);
            }
        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
