<?php

namespace AM2Studio\LaravelAccess\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role_permission';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'permission_id', 'model_id', 'model_type'];

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