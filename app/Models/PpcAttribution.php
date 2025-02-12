<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $platform
 * @property int $clicks
 * @property int $conversions
 * @property string $cost
 * @property string $revenue
 * @property string $roas
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereRoas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PpcAttribution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PpcAttribution extends Model
{
    use HasFactory;

    protected $table = 'ppc_attribution'; // ✅ Ensure correct table name

    protected $fillable = [
        'platform',
        'clicks',
        'conversions',
        'cost',
        'revenue',
        'google_roas',
        'meta_roas',
        'tiktok_roas',
        'total_roas',
        'date'
    ];

    /**
     * Automatically calculate ROAS when saving.
     */
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->cost > 0) {
                $model->roas = $model->revenue / max($model->cost, 1);
            } else {
                $model->roas = 0;
            }
        });
    }
}
