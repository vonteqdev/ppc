<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $email
 * @property string $frequency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportSchedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReportSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'frequency'];
}
