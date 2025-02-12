<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $google_analytics_account_id
 * @property string $property_id
 * @property string $name
 * @property string $display_name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GoogleAnalyticsAccount|null $account
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereGoogleAnalyticsAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsProperty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoogleAnalyticsProperty extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function account()
    {
        return $this->belongsTo(GoogleAnalyticsAccount::class);
    }
}
