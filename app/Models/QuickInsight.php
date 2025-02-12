<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $importance
 * @property string $message
 * @property string $timestamp
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereImportance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuickInsight whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuickInsight extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'importance', 'timestamp'];

    public $timestamps = false;
}
