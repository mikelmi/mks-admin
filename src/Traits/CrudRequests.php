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
     * @parem null $mode
     * @return AdminForm
     */
    protected function form($model = null, $mode = null): AdminForm
    {
        if ($modelInstance = $this->formModel($model)) {
            $form = AdminModelForm($modelInstance);
        } else {
            $form = new AdminForm();
        }

        if ($mode) {
            $form->setMode($mode);
        }

        return $form;
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
        $form = $this->form($this->formModel(), AdminForm::MODE_CREATE);

        $form->setupCreateMode();

        return $form->response();
    }

    /**
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($model)
    {
        $form = $this->form($this->formModel($model), AdminForm::MODE_EDIT);

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
    public function save(Request $request, $model)
    {}

    public function show($model)
    {
        $form = $this->form($this->formModel($model), AdminForm::MODE_VIEW);

        $form->setupViewMode();

        return $form->response();
    }
}