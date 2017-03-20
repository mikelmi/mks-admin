<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 15:53
 */

namespace Mikelmi\MksAdmin\Form;


use Illuminate\Support\Collection;

class FormGroup
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $icon = '';

    /**
     * @var bool
     */
    private $active = false;

    /**
     * @var Collection
     */
    private $fields;

    /**
     * @var bool
     */
    private $disabled = false;

    public function __construct(string $id, string $title = null, string $icon = null)
    {
        $this->fields = collect();

        if ($title) {
            $this->title = $title;
        }

        if ($icon) {
            $this->icon = $icon;
        }

        $this->setId($id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return FormGroup
     */
    public function setId(string $id): FormGroup
    {
        $this->id = $id;

        if (!$this->title) {
            $this->title = ucwords($id);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return FormGroup
     */
    public function setTitle(string $title): FormGroup
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return FormGroup
     */
    public function setIcon(string $icon): FormGroup
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return FormGroup
     */
    public function setActive(bool $active): FormGroup
    {
        $this->active = $active;
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
     * @return FormGroup
     */
    public function setDisabled(bool $disabled): FormGroup
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return 'tab-' . $this->getId();
    }

    /**
     * @param FieldInterface|array $field
     * @param array $options
     * @return FormGroup
     */
    public function addField($field, array $options = []): FormGroup
    {
        if (!$field instanceof FieldInterface) {
            if (!is_array($field)) {
                throw new \InvalidArgumentException("$field should be an array or instance of Field");
            }

            $type = array_pull($field, 'type', 'text');
            $options = array_merge($field, $options);
            $this->fields->push(FieldFactory::make($type, $options));
        } else {
            if ($options) {
                FieldFactory::applySetters($field, $options);
            }

            $this->fields->push($field);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return FormGroup
     */
    public function setFields(array $fields): FormGroup
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param array $options
     * @return string
     */
    public function navLink(array $options = []): string
    {
        $attr = [
            'class' => 'nav-link',
            'href' => '#',
            'role' => 'tab',
            'data-target' => '#' . $this->getTarget(),
            'data-toggle' => 'tab',
        ];

        if ($this->active) {
            $attr['class'] .= ' active';
        }

        if ($this->disabled) {
            $attr['class'] .= ' disabled';
        }

        $attr = array_merge($attr, $options);

        return sprintf(
            '<li class="nav-item">
                <a %s>%s%s</a>
            </li>',
            html_attr($attr),
            $this->icon ? '<i class="fa fa-'.$this->icon.'"></i> ':'',
            $this->title
        );
    }

    /**
     * @param array $options
     * @return array
     */
    public function paneAttributes(array $options = []): array
    {
        $attr = [
            'class' => 'tab-pane',
            'role' => 'tabpanel',
            'id' => $this->getTarget()
        ];

        if ($this->active) {
            $attr['class'] .= ' active';
        }

        if ($this->disabled) {
            $attr['class'] .= ' disabled';
        }

        return array_merge($attr, $options);
    }
}