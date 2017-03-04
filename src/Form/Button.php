<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:08
 */

namespace Mikelmi\MksAdmin\Form;


class Button
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $type;

    /**
     * @var null|string
     */
    protected $icon;

    /**
     * @var bool
     */
    protected $showTitle = true;

    /**
     * @var string
     */
    protected $onClick;

    /**
     * @var array;
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $size;

    /**
     * ToolButton constructor.
     * @param string $url
     * @param string|null $title
     * @param string|null $type
     * @param string|null $icon
     */
    public function __construct(string $url, string $title = null, string $type = null, string $icon = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->type = $type;
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
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
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param null|string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    protected function getClass(): string
    {
        $result = 'btn btn-' . ($this->type ?: 'secondary');

        if ($this->size) {
            $result .= ' btn-' . $this->size;
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function defaultAttributes(): array
    {
        $result = [
            'class' => $this->getClass(),
            'title' => $this->title,
            'data-url' => $this->url
        ];

        if ($this->onClick) {
            $result['ng-click'] = $this->onClick;
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function iconHtml(): string
    {
        return $this->icon ? '<i class="fa fa-' . $this->icon .'"></i>' : '';
    }

    /**
     * @return bool
     */
    public function isShowTitle(): bool
    {
        return $this->showTitle;
    }

    /**
     * @param bool $showTitle
     */
    public function setShowTitle(bool $showTitle)
    {
        $this->showTitle = $showTitle;
    }

    /**
     * @return string
     */
    public function getOnClick(): string
    {
        return $this->onClick;
    }

    /**
     * @param string $onClick
     */
    public function setOnClick(string $onClick)
    {
        $this->onClick = $onClick;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size (sm or lg)
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }


    /**
     * @return string
     */
    public function render(): string
    {
        $attr = array_merge($this->defaultAttributes(), $this->getAttributes());

        return sprintf(
            '<button %s>%s %s</button>',
            html_attr($attr),
            $this->iconHtml(),
            $this->showTitle || !$this->icon ? $this->title : ''
            );
    }
}