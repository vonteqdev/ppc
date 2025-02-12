<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $platform
 * @property string $ad_name
 * @property string $recommendation_type
 * @property string $message
 * @property int $action_taken
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereActionTaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereAdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereRecommendationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcRecommendation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PpcRecommendation extends Model
{
    //
}
