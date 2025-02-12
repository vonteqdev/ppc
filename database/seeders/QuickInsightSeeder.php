<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuickInsight;

class QuickInsightSeeder extends Seeder
{
    public function run()
    {
        QuickInsight::insert([
            ['message' => 'Ad spending is 10% over budget!', 'importance' => 'critical', 'timestamp' => now()],
            ['message' => 'Your best-performing ad has 30% more clicks than last week.', 'importance' => 'good', 'timestamp' => now()],
            ['message' => 'Consider optimizing low-performing keywords.', 'importance' => 'important', 'timestamp' => now()],
        ]);
    }
}
