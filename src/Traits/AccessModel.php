<?php

namespace AM2Studio\LaravelAccess\Traits;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class AccessModel
 * @package AM2Studio\LaravelAccess\Traits
 */
trait AccessModel
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public static function create(array $attributes = [])
    {
        if(isset($attributes['model']) && !$attributes['model'] instanceof Model) {
            throw new InvalidArgumentException('Parameter "model" must be an instance of Eloquent model!');
        }

        if(isset($attributes['model'])) {
            $attributes['model'] = get_class($attributes['model']);
        }

        return parent::create($attributes);
    }
}