<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class StudioResource
 * @package App\Models
 *
 * @property int $id
 * @property int $studio_id
 * @property string $url
 *
 * @property Studio $studio
 */
class StudioResource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studio_id',
        'url'
    ];

    /**
     * Current studioResource studio
     *
     * @return BelongsTo
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
