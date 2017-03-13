<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 11:48
 */

namespace Mikelmi\MksAdmin\Form;


abstract class Field
{
    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $label = '';

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @var bool
     */
    protected $readOnly = false;

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $layout = '';

    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var string
     */
    protected $class = 'form-control';

    /**
     * Field constructor.
     * @param string|null $name
     * @param mixed|null $value
     * @param string|null $label
     */
    public function __construct(string $name = null, $value = null, string $label = null)
    {
        if ($value) {
            $this->value = $value;
        }

        if ($label) {
            $this->label = $label;
        }

        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Field
     */
    public function setName(string $name): Field
    {
        $this->name = $name;

        if ($name && !$this->label) {
            $this->label = ucwords($this->name);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Field
     */
    public function setLabel(string $label): Field
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return Field
     */
    public function setRequired(bool $required): Field
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param bool $readOnly
     * @return Field
     */
    public function setReadOnly(bool $readOnly): Field
    {
        $this->readOnly = $readOnly;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return Field
     */
    public function setDisabled(bool $disabled): Field
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return array_merge($this->getDefaultAttributes(), $this->attributes);
    }

    /**
     * @param array $attributes
     * @return Field
     */
    public function setAttributes(array $attributes): Field
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $key
     * @param null $value
     * @return Field
     */
    public function setAttribute(string $key, $value = null): Field
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout ?: AdminForm::getLayout();
    }

    /**
     * @param string $layout
     * @return Field
     */
    public function setLayout(string $layout): Field
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return Field
     */
    public function setTemplate(string $template): Field
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        if (!$this->id) {
            $this->id = $this->name ? 'field-' . $this->name : 'field-' . uniqid();
        }

        return $this->id;
    }

    /**
     * @param string $id
     * @return Field
     */
    public function setId(string $id): Field
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return Field
     */
    public function setClass(string $class): Field
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Field
     */
    public function setValue($value): Field
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return array
     */
    protected function getDefaultAttributes(): array
    {
        return array_filter([
            'id' => $this->getId(),
            'name' => $this->name,
            'required' => $this->isRequired(),
            'disabled' => $this->isDisabled(),
            'readonly' => $this->isReadOnly(),
            'class' => $this->getClass(),
        ]);
    }

    /**
     * @return string
     */
    public function render():string
    {
        $template = $this->template;

        if (!$template) {
            $template = 'admin::form.field-layout-' . ($this->getLayout() ?: 'default');
        }

        return view($template, ['field' => $this]);
    }

    /**
     * @param $type
     * @param array $options
     * @return Field
     */
    public static function make($type, array $options = [])
    {
        $class = config('admin.form.fields.' . $type);

        if (!$class) {
            $class = __NAMESPACE__ . '\\Field\\' . ucfirst($type);
        }

        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Class ' . $class . ' not found');
        }

        $field = new $class;
        $field->applySetters($options);

        return $field;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function applySetters(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            } elseif (!is_array($value)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }


    /**
     * @return string
     */
    abstract public function renderInput(): string;
}