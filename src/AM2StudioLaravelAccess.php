<?php

namespace AM2Studio\LaravelAccess;

use AM2Studio\LaravelAccess\Models\Permission;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AM2StudioLaravelAccess
 * @package AM2Studio\LaravelAccess
 */
class AM2StudioLaravelAccess
{
    /**
     * @param $permission
     * @param null $model
     * @return bool
     */
    public function permissionHasModel($permission, $model = null)
    {
        $permission = Permission::find($permission);
        if($permission->model != $this->getClassName($model)) {
            return false;
        }
        return true;
    }

    /**
     * @param null $model
     * @return null|string
     */
    public function getClassName($model = null)
    {
        if($model instanceof Model) {
            return get_class($model);
        }

        return $model;
    }

    /**
     * @param null $model
     * @return mixed
     */
    public function getPermissions($model = null)
    {
        return Permission::all();
    }

    /**
     * @param null $model
     * @return mixed
     */
    public function getPermissionsByModel($model = null)
    {
        if(!$model) {
            return Permission::whereNull('model')->get();
        }

        $className = $this->getClassName($model);

        return Permission::where('model', $className)->get();
    }

    /**
     * @param $group
     * @return mixed
     */
    public function getPermissionsByGroup($group)
    {
        return Permission::where('group', $group)->get();
    }
}