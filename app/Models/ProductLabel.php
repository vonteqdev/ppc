<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $product_id
 * @property string $label
 * @property string|null $roas
 * @property string|null $conversion_rate
 * @property int|null $clicks
 * @property int|null $impressions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereConversionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereImpressions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereRoas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLabel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductLabel extends Model
 {
     use HasFactory;

     protected $fillable = [
         'product_id',
         'label',
         'roas',
         'conversion_rate',
         'clicks',
         'impressions'
     ];

     public function product()
     {
         return $this->belongsTo(Product::class);
     }

     public function labels() {
         return $this->hasMany(ProductLabel::class);
     }

 }
