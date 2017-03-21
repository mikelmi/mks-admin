<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 16:30
 */

namespace Mikelmi\MksAdmin\Form;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminModelForm extends AdminForm
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $casts = [];

    /**
     * AdminModelForm constructor.
     * @param Model $model
     */
    public function __construct(Model $model = null)
    {
        parent::__construct();

        if ($model) {
            $this->setModel($model);
        }
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     * @return AdminModelForm
     */
    public function setModel(Model $model): AdminModelForm
    {
        $this->model = $model;
        $this->casts = $this->model->getCasts();

        foreach ($this->model->getDates() as $key) {
            $this->casts[$key] = 'date';
        }

        $idKey = $this->model->getKeyName();
        if ($idKey) {
            $this->casts[$idKey] = 'staticText';
        }

        if ($this->model->getKey()) {
            $this->setMode(self::MODE_EDIT);
        }

        if ($this->isSoftDeletableModel()) {
            $this->alertWarning(__('admin::messages.In Trash'), 'exclamation-triangle');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSoftDeletableModel(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive($this->model)) && $this->model->trashed();
    }

    /**
     * @return array
     */
    public function getCasts(): array
    {
        return $this->casts;
    }

    /**
     * @param array $casts
     * @return AdminModelForm
     */
    public function setCasts(array $casts): AdminModelForm
    {
        $this->casts = array_merge($this->casts, $casts);
        return $this;
    }

    /**
     * @param $key
     * @return null|string
     */
    protected function getCastType($key)
    {
        if (!$key) {
            return null;
        }

        return trim(lcfirst(array_get($this->getCasts(), $key)));
    }

    protected function castToType($key)
    {
        $type = $this->getCastType($key);

        switch ($type) {
            case 'int':
            case 'integer':
                return 'number';
            case 'real':
            case 'float':
            case 'double':
                return 'number';
            case 'string':
                return 'text';
            case 'bool':
            case 'boolean':
                return 'checkbox';
            case 'object':
                return 'textarea';
            case 'array':
            case 'json':
                return 'select';
            case 'collection':
                return 'select';
            case 'date':
                return 'date';
            case 'datetime':
                return 'text';
            case 'timestamp':
                return 'text';
            case 'static':
            case 'staticText':
                return 'staticText';
            default:
                return 'text';
        }
    }

    protected function makeModelField(string $name, $label = null, $type = null): FieldInterface
    {
        if (!$type) {
            $type = $this->castToType($name);
        }

        $field = FieldFactory::make($type);
        $field->setName($name);
        if ($label) {
            $field->setLabel($label);
        }

        $field->setValue($this->model->getAttribute($name));

        return $field;
    }

    /**
     * @param string $name
     * @param null $label
     * @param null $type
     * @return FieldInterface
     */
    public function addModelField(string $name, $label = null, $type = null): FieldInterface
    {
        $field = $this->makeModelField($name, $label, $type);
        $this->addField($field);

        return $field;
    }

    public function setFields(array $fields): AdminForm
    {
        foreach($fields as $field)
        {
            if (is_array($field) && ($name = array_pull($field, 'name'))) {
                $modelField = $this->addModelField($name, array_pull($field, 'label', ''), array_pull($field, 'type'));
                FieldFactory::applySetters($modelField, $field);
                continue;
            }

            $this->addField($field);
        }

        return $this;
    }

    protected function setGroupFields(FormGroup $group, array $fields = [])
    {
        foreach($fields as $field)
        {
            if (is_array($field) && ($name = array_pull($field, 'name'))) {
                $modelField = $this->makeModelField($name, array_pull($field, 'label', ''), array_pull($field, 'type'));
                FieldFactory::applySetters($modelField, $field);
                $group->addField($modelField);
                continue;
            }

            $group->addField($field);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasModel(): bool
    {
        return !empty($this->model);
    }

    public function isInTrash(): bool
    {
        if ($this->model && $this->isSoftDeletableModel()) {
            return $this->model->trashed();
        }

        return false;
    }
}