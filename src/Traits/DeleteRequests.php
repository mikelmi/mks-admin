<?php
/**
 * Author: mike
 * Date: 16.03.17
 * Time: 14:31
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Http\Request;

trait DeleteRequests
{
    protected function deletableQuery()
    {
        return call_user_func([ModelTraitHelper::getModelClass($this), 'query']);
    }

    public function delete(Request $request, $id = null)
    {
        if ($id === null) {
            $id = $request->get('id', []);
        }

        $primaryKeyName = ModelTraitHelper::getPrimaryKeyName($this);

        $res = $this->deletableQuery()->whereIn($primaryKeyName, (array)$id)->delete();

        if (!$res) {
            app()->abort(422);
        }

        return response()->json($res);
    }
}