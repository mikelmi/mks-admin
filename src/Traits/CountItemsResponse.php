<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 12:26
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Http\Response;

trait CountItemsResponse
{
    public function getItemsCount($scope = null)
    {
        if ($scope == 'trash') {
            return ModelTraitHelper::query($this)->onlyTrashed()->count();
        }

        return ModelTraitHelper::query($this)->count();
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function setItemsCount($response)
    {
        $scopes = property_exists($this, 'countScopes') ? $this->countScopes : null;

        if (!$scopes) {
            return $response;
        }

        $counts = [];

        foreach($scopes as $scope) {
            $counts['count_' . $scope] = $this->getItemsCount($scope);
        }

        if (!$response instanceof \Symfony\Component\HttpFoundation\Response) {
            $response = response($response);
        }

        return $response->header('X-Model-Data', json_encode($counts));
    }
}