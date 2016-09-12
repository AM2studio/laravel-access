<?php

namespace AM2Studio\LaravelAccess;

use AM2Studio\LaravelAccess\Models\Permission;
use AM2Studio\LaravelAccess\Models\Role;
use Illuminate\Database\Eloquent\Model;

class AM2StudioLaravelAccess
{
    public function roleHasModel($role, $model = null)
    {
        $role = Role::find($role);
        if($role->model != $this->getClassName($model)) {
            return false;
        }
        return true;
    }

    public function permissionHasModel($permission, $model = null)
    {
        $permission = Permission::find($permission);
        if($permission->model != $this->getClassName($model)) {
            return false;
        }
        return true;
    }

    public function getClassName($model = null)
    {
        if($model instanceof Model) {
            return get_class($model);
        }

        return $model;
    }

    public function getPermissions($model = null)
    {
        if(!$model) {
            return Permission::whereNotNull('model')->get();
        }

        $className = $this->getClassName($model);

        return Permission::where('model', $className)->get();
    }
}