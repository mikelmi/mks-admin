<?php
/**
 * Author: mike
 * Date: 21.03.17
 * Time: 11:10
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mikelmi\MksAdmin\Form\AdminForm;
use Mikelmi\MksAdmin\Form\AdminModelForm;

trait CrudRequests
{
    use DataGridRequests;
    use DeleteRequests;

    /**
     * @param null $model
     * @return AdminForm
     */
    protected function form($model = null): AdminForm
    {
        if ($modelInstance = $this->formModel($model)) {
            return new AdminModelForm($modelInstance);
        }

        return new AdminForm();
    }

    /**
     * @param null $model
     * @return Model|mixed|null
     */
    protected function formModel($model = null)
    {
        if ($model) {
            if ($model instanceof Model) {
                return $model;
            } else {
                return ModelTraitHelper::query($this)->find($model);
            }
        } elseif (property_exists($this, 'modelClass')) {
            return ModelTraitHelper::modelInstance($this);
        }

        return null;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $form = $this->form($this->formModel());

        $form->setupCreateMode();

        return $form->response();
    }

    /**
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($model)
    {
        $form = $this->form($this->formModel($model));

        $form->setupEditMode();

        return $form->response();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function store(Request $request)
    {
        return $this->save($request, $this->formModel());
    }

    /**
     * @param Request $request
     * @param $model
     * @return bool
     */
    public function update(Request $request, $model)
    {
        return $this->save($request, $this->formModel($model));
    }

    /**
     * @param Request $request
     * @param $model
     * @return bool
     */
    abstract public function save(Request $request, $model);

    public function show($model)
    {
        $form = $this->form($this->formModel($model));

        $form->setupViewMode();

        return $form->response();
    }
}