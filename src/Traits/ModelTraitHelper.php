<?php
/**
 * Author: mike
 * Date: 05.03.17
 * Time: 1:11
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @param $class
     * @return string
     */
    public static function getModelClass($class)
    {
        self::checkModelClass($class);

        return $class->modelClass;
    }

    /**
     * @param $class
     * @return string
     */
    public static function getPrimaryKeyName($class)
    {
        $modelClass = static::getModelClass($class);

        return (new $modelClass)->getKeyName();
    }

    /**
     * @param $class
     * @return Builder
     */
    public static function query($class)
    {
        $modelClass = static::getModelClass($class);

        return $modelClass::query();
    }

    /**
     * @param $class
     * @return bool
     */
    public static function isUsesCountItems($class): bool
    {
        return in_array(CountItemsResponse::class, class_uses($class));
    }

    /**
     * @param $class
     * @param $response
     * @return mixed
     */
    public static function applyCountItemsResponse($class, $response)
    {
        if (static::isUsesCountItems($class)) {
            return call_user_func([$class, 'setItemsCount'], $response);
        }

        return $response;
    }

    /**
     * @param $class
     * @return Model
     */
    public static function modelInstance($class)
    {
        $modelClass = static::getModelClass($class);

        return new $modelClass;
    }
}