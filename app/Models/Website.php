<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $google_analytics_property_id
 * @property string $name
 * @property string $url
 * @property string|null $feed_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereGoogleAnalyticsPropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereUserId($value)
 * @mixin \Eloquent
 */
class Website extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
