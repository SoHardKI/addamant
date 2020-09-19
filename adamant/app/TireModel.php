<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TireModel
 * @package App
 * @property $name
 */
class TireModel extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Шины модели
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tires()
    {
        return $this->hasMany(Tire::class);
    }
}
