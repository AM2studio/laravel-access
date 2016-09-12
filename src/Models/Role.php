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

    public function attachPermission($permission, $permissionModel = null, $roleModel = null)
    {
        if(!Access::roleHasModel($this->id, $roleModel)) {
            throw new InvalidArgumentException('Selected role does not match selected model!');
        }

        if(!Access::permissionHasModel($permission, $permissionModel)) {
            throw new InvalidArgumentException('Selected permission does not match selected model!');
        }
    }

    public function hasPermission()
    {

    }

    public function attachPermission($permission, $model = null)
    {
        $attributes = [];

        if(!Access::permissionHasModel($permission, $model)) {
            throw new InvalidArgumentException('Selected permission does not match selected model!');
        }

        if($model instanceof Model) {
            $attributes['model_id'] = $model->getKey();
        }

        return (!$this->hasPermission($permission, $model)) ? $this->permissions()->attach($permission, $attributes) : true;
    }

    public function hasPermission($permission, $model = null)
    {
        return $this->permissions->contains(function($value, $key) use ($permission, $model){
            return ($permission == $value->id || str_is($permission, $value->slug)) && Access::getClassName($model); });
    }
}