<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $source
 * @property string $type
 * @property string $frequency
 * @property string|null $last_fetched_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereLastFetchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedImport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeedImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'source', 'type', 'frequency', 'last_fetched_at'
    ];
}
