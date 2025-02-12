<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $email
 * @property string $access_token
 * @property string $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GoogleAnalyticsAccount> $analyticsAccounts
 * @property-read int|null $analytics_accounts_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GoogleAccount whereUserId($value)
 * @mixin \Eloquent
 */
class GoogleAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function analyticsAccounts()
    {
        return $this->hasMany(GoogleAnalyticsAccount::class);
    }
}
