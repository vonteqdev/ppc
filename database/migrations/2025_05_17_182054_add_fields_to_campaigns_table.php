<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCampaignsTable extends Migration
{
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'impressions')) {
                $table->bigInteger('impressions')->default(0)->after('type');
            }
            if (!Schema::hasColumn('campaigns', 'clicks')) {
                $table->bigInteger('clicks')->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'conversions')) {
                $table->bigInteger('conversions')->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'conversion_rate')) {
                $table->decimal('conversion_rate', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'cost')) {
                $table->decimal('cost', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'cost_per_conversion')) {
                $table->decimal('cost_per_conversion', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('campaigns', 'cpc')) {
                $table->decimal('cpc', 10, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'impressions',
                'clicks',
                'conversions',
                'conversion_rate',
                'cost',
                'cost_per_conversion',
                'cpc',
            ]);
        });
    }
}

