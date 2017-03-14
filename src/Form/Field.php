<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 11:48
 */

namespace Mikelmi\MksAdmin\Form;


abstract class Field implements FieldInterface
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
     * @var string
     */
    protected $placeholder = '';

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
     * @return FieldInterface
     */
    public function setName(string $name): FieldInterface
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
     * @return FieldInterface
     */
    public function setLabel(string $label): FieldInterface
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
     * @return FieldInterface
     */
    public function setRequired(bool $required): FieldInterface
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
     * @return FieldInterface
     */
    public function setReadOnly(bool $readOnly): FieldInterface
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
     * @return FieldInterface
     */
    public function setDisabled(bool $disabled): FieldInterface
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
     * @return FieldInterface
     */
    public function setAttributes(array $attributes): FieldInterface
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $key
     * @param null $value
     * @return FieldInterface
     */
    public function setAttribute(string $key, $value = null): FieldInterface
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
     * @return FieldInterface
     */
    public function setLayout(string $layout): FieldInterface
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
     * @return FieldInterface
     */
    public function setTemplate(string $template): FieldInterface
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
     * @return FieldInterface
     */
    public function setId(string $id): FieldInterface
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
     * @return FieldInterface
     */
    public function setClass(string $class): FieldInterface
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
     * @return FieldInterface
     */
    public function setValue($value): FieldInterface
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
            'placeholder' => $this->getPlaceholder(),
        ]);
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return FieldInterface
     */
    public function setPlaceholder(string $placeholder): FieldInterface
    {
        $this->placeholder = $placeholder;
        return $this;
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