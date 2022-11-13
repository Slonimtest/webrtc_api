<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Studio
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 *
 * @property Setting $setting
 */
class Studio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * Current studio settings
     *
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    /**
     * Current studio studioResource
     *
     * @return HasMany
     */
    public function studioResources(): HasMany
    {
        return $this->hasMany(StudioResource::class);
    }
}
