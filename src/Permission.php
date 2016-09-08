<?php

namespace AM2Studio\LaravelAccess;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Permission extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'model'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    public static function create(array $attributes = [])
    {
        if(!isset($attributes['model']) || !$attributes['model'] instanceof Model) {
            throw new InvalidArgumentException('Parameter "model" must be an instance of Eloquent model!');
        }

        $attributes['model'] = get_class($attributes['model']);

        return parent::create($attributes);
    }

}