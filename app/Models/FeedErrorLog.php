<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $feed_name
 * @property string $error_message
 * @property string $logged_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereFeedName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereLoggedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedErrorLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeedErrorLog extends Model
{
    //
}
