<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Manufacturer
 * @package App
 * @property $name
 */
class Manufacturer extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Шины производителя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tires()
    {
        return $this->hasMany(Tire::class);
    }
}
