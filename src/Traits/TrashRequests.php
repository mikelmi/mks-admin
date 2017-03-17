<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 11:56
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Http\Request;

trait TrashRequests
{
    public function toTrash(Request $request, $id = null)
    {
        ModelTraitHelper::checkModelClass($this);

        $ids = $id ? $id : $request->input('id');

        $res = call_user_func([$this->modelClass, 'destroy'], $ids);

        return $this->afterTrash(response()->json($res));
    }

    public function restore(Request $request, $id = null)
    {
        ModelTraitHelper::checkModelClass($this);

        $ids = $id ? $id : $request->input('id');

        $res = call_user_func([$this->modelClass, 'onlyTrashed'], $ids)
                    ->whereIn('id', (array)$ids)->restore();

        return $this->afterRestore(response()->json($res));
    }

    protected function afterTrash($response)
    {
        return ModelTraitHelper::applyCountItemsResponse($this, $response);
    }

    protected function afterRestore($response)
    {
        return ModelTraitHelper::applyCountItemsResponse($this, $response);
    }
}