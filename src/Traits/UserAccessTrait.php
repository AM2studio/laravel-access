<?php

namespace AM2Studio\LaravelAccess\Traits;

use AM2Studio\LaravelAccess\Access;
use AM2Studio\LaravelAccess\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class UserAccessTrait
 * @package AM2Studio\LaravelAccess\Traits
 */
trait UserAccessTrait
{
    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id')
            ->withTimestamps()
            ->withPivot('model_id');
    }

    /**
     * @param $permission
     * @param null $model
     * @return bool
     */
    public function attachPermission($permission, $model = null)
    {
        $attributes = [];

        if($model instanceof Model) {
            if(!Access::permissionHasModel($permission, $model)) {
                throw new InvalidArgumentException('Selected permission does not match selected model!');
            }

            $attributes['model_id'] = $model->getKey();
        } elseif($model) {
            $attributes['model_id'] = $model;
        }

        return (!$this->hasPermission($permission, $model)) ? $this->permissions()->attach($permission, $attributes) : true;
    }

    /**
     * @param $permission
     * @param null $model
     * @return mixed
     */
    public function detachPermission($permission, $model = null)
    {
        $modelId = null;

        if($model instanceof Model) {
            if(!Access::permissionHasModel($permission, $model)) {
                throw new InvalidArgumentException('Selected permission does not match selected model!');
            }

            $modelId = $model->getKey();
        } elseif($model) {
            $modelId = $model;
        }

        if($model) {
            return $this->permissions()->newPivotStatementForId($permission)->where('model_id', $modelId)->delete();
        } else {
            return $this->permissions()->detach($permission);
        }
    }

    /**
     * @param $permission
     * @param null $model
     * @return bool|mixed
     */
    public function togglePermission($permission, $model = null)
    {
        if($this->hasPermission($permission, $model)) {
            return $this->detachPermission($permission, $model);
        } else {
            return $this->attachPermission($permission, $model);
        }
    }

    /**
     * @param $permission
     * @param null $model
     * @return mixed
     */
    public function hasPermission($permission, $model = null)
    {
        return $this->permissions->contains(function($key, $value) use ($permission, $model) {
            if ($permission == $value->id || str_is($permission, $value->slug)) {
                if ($model) {
                    if($model instanceof Model) {
                        return Access::getClassName($model) == $value->model && $value->pivot->model_id == $model->getKey();
                    } else {
                        return $value->pivot->model_id == $model;
                    }
                }
                return true;
            }
            return false;
        });
    }
}