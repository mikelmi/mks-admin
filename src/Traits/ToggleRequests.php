<?php
/**
 * Author: mike
 * Date: 05.03.17
 * Time: 0:34
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait ToggleRequests
{
    /**
     * @param Model|mixed $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle($model)
    {
        $model = ModelTraitHelper::getModel($this, $model);

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
        ModelTraitHelper::checkModelClass($this);

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