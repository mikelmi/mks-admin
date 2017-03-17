<?php
/**
 * Author: mike
 * Date: 16.03.17
 * Time: 14:31
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

trait DeleteRequests
{
    protected function deletableQuery()
    {
        return ModelTraitHelper::query($this);
    }

    public function delete(Request $request, $id = null)
    {
        if ($id === null) {
            $id = $request->get('id', []);
        }

        $primaryKeyName = ModelTraitHelper::getPrimaryKeyName($this);

        $deleteMethod = 'delete';

        if (in_array(SoftDeletes::class, class_uses_recursive($this->modelClass))) {
            $deleteMethod = 'forceDelete';
        }

        $res = $this->deletableQuery()->whereIn($primaryKeyName, (array)$id)->$deleteMethod();

        if (!$res) {
            app()->abort(422);
        }

        return $this->afterDelete(response()->json($res));
    }

    protected function afterDelete($response)
    {
        return ModelTraitHelper::applyCountItemsResponse($this, $response);
    }
}