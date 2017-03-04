<?php
/**
 * Author: mike
 * Date: 05.03.17
 * Time: 1:03
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Model;

trait MoveRequests
{
    /**
     * @param Model|mixed $model
     * @param bool $down
     * @return \Illuminate\Http\JsonResponse
     */
    function move($model, $down = false)
    {
        $model = ModelTraitHelper::getModel($this, $model);

        $field = $this->moveField ?? 'priority';

        if ($down) {
            $model->$field--;
        } else {
            $model->$field++;
        }

        $model->save();

        return response()->json([
            'model' => [
                $field => $model->$field
            ]
        ]);
    }
}