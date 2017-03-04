<?php
/**
 * Author: mike
 * Date: 05.03.17
 * Time: 1:11
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelTraitHelper
{
    public static function checkModelClass($class)
    {
        if (!property_exists($class, 'modelClass')) {
            abort(500, 'Property modelClass does not exists');
        }
    }

    /**
     * @param $class
     * @param Model|mixed $model
     * @return mixed
     */
    public static function getModel($class, $model)
    {
        self::checkModelClass($class);

        if (!$model instanceof Model) {
            $model = call_user_func([$class->modelClass, 'find'], $model);
        }

        if (!$model->exists) {
            throw new ModelNotFoundException(get_class($model));
        }

        return $model;
    }
}