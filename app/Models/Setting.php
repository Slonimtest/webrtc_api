<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Setting
 * @package App\Models
 *
 * @property int $id
 * @property int $studio_id
 * @property object|null $setting
 *
 * @property Studio $studio
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'object'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studio_id',
        'options'
    ];

    /**
     * Current setting studio
     *
     * @return BelongsTo
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
