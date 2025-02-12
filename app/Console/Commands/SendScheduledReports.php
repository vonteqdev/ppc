<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReportSchedule;
use Illuminate\Support\Facades\Mail;

class SendScheduledReports extends Command
{
    protected $signature = 'reports:send';
    protected $description = 'Send scheduled PPC performance reports.';

    public function handle()
    {
        $schedules = ReportSchedule::all();

        foreach ($schedules as $schedule) {
            // Fetch PPC Performance Data (Google Ads, Meta, TikTok)
            $data = [
                'email' => $schedule->email,
                'performance' => [
                    'Google Ads' => ['clicks' => 500, 'conversions' => 20, 'roas' => 4.5],
                    'Meta Ads' => ['clicks' => 300, 'conversions' => 15, 'roas' => 3.2],
                    'TikTok Ads' => ['clicks' => 100, 'conversions' => 5, 'roas' => 2.8]
                ]
            ];

            // Send Email
            Mail::send('emails.report', $data, function ($message) use ($schedule) {
                $message->to($schedule->email)->subject('PPC Performance Report');
            });

            $this->info("Report sent to {$schedule->email}");
        }
    }
}
