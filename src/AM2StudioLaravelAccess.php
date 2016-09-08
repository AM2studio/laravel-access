<?php

namespace AM2Studio\LaravelAccess;

use AM2Studio\LaravelAccess\Models\Role;

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

    public function getClassName($model = null)
    {
        if($model) {
            return get_class($model);
        }
        return null;
    }
}