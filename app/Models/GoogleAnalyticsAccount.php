<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $google_account_id
 * @property string $account_id
 * @property string $name
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\GoogleAccount $googleAccount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GoogleAnalyticsProperty> $properties
 * @property-read int|null $properties_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereGoogleAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAnalyticsAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoogleAnalyticsAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    }

    public function properties()
    {
        return $this->hasMany(GoogleAnalyticsProperty::class);
    }
}
