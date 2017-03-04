<?php
/**
 * Author: mike
 * Date: 05.03.17
 * Time: 0:34
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

trait ToggleRequests
{
    private function checkModelClass()
    {
        if (!property_exists($this, 'modelClass')) {
            abort(500, 'Property modelClass does not exists');
        }
    }

    /**
     * @param Model|mixed $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle($model)
    {
        $this->checkModelClass();

        if (!$model instanceof Model) {
            $model = call_user_func([$this->modelClass, 'find'], $model);
        }

        if (!$model->exists) {
            throw new ModelNotFoundException(get_class($model));
        }

        $field = $this->toggleField ?? 'status';

        $model->setAttribute($field, !$model->getAttribute($field));
        $model->save();

        return response()->json([
            'model' => [
                $field => $model->getAttribute($field)
            ]
        ]);
    }

    public function toggleBatch(Request $request, $status)
    {
        $this->checkModelClass();

        $id = $request->get('id', []);

        $field = $this->toggleField ?? 'status';

        $idKey = call_user_func([new $this->modelClass, 'getKeyName']);

        $res = call_user_func([$this->modelClass, 'whereIn'], $idKey, $id)->update([
            $field => $status
        ]);

        if (!$res) {
            app()->abort(402);
        }

        $data = [];
        $models = call_user_func([$this->modelClass, 'whereIn'], $idKey, $id)->get();

        foreach($models as $model) {
            $data[$model->id] = [
                $field => $model->$field
            ];
        }

        return response()->json([
            'models' => $data
        ]);
    }
}