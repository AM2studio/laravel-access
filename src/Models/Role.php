<?php

namespace AM2Studio\LaravelAccess\Models;

use AM2Studio\LaravelAccess\Access;
use AM2Studio\LaravelAccess\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class Role
 * @package AM2Studio\LaravelAccess
 */
class Role extends Model  {

    use AccessModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
}