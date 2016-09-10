<?php

namespace AM2Studio\LaravelAccess\Traits;

use AM2Studio\LaravelAccess\Access;
use AM2Studio\LaravelAccess\Models\Permission;
use AM2Studio\LaravelAccess\Models\Role;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait HasRolesAndPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id')->withTimestamps();
    }

    public function attachRole($role, $model = null)
    {
        $attributes = [];

        if(!Access::roleHasModel($role, $model)) {
            throw new InvalidArgumentException('Selected role does not match selected model!');
        }

        if($model instanceof Model) {
            $attributes['model_id'] = $model->getKey();
        }

        return (!$this->hasRole($role, $model)) ? $this->roles()->attach($role, $attributes) : true;
    }

    public function hasRole($role, $model = null)
    {
        return $this->roles->contains(function($value, $key) use ($role, $model){
            return ($role == $value->id || str_is($role, $value->slug)) && Access::getClassName($model);
        });
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
            return ($permission == $value->id || str_is($permission, $value->slug)) && Access::getClassName($model); }); }

}