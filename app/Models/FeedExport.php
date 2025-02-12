<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $platform
 * @property string $export_url
 * @property array<array-key, mixed>|null $columns
 * @property array<array-key, mixed>|null $filters
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereColumns($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereExportUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereFilters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeedExport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeedExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'platform',
        'export_url',
        'columns',
        'filters',
        'label_filters' // New field
    ];

    protected $casts = [
        'columns' => 'array',
        'filters' => 'array'
    ];
}
