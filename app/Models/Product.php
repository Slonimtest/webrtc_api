<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Product
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $video
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'images',
        'videos',
        'studio_id'
    ];

    /**
     * Current product studio
     *
     * @return BelongsTo
     */
    public function studios(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
