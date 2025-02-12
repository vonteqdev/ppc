<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $platform
 * @property string $label
 * @property string $metric
 * @property string $condition
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabelingRule whereValue($value)
 * @mixin \Eloquent
 */
class LabelingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'label',
        'metric',
        'condition',
        'value'
    ];
}
