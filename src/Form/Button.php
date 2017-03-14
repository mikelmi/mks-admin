<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:08
 */

namespace Mikelmi\MksAdmin\Form;


class Button implements ButtonInterface
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
    protected $btnType;

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
     * @param string|null $url
     * @param string|null $title
     * @param string|null $btnType
     * @param string|null $icon
     */
    public function __construct(string $url = '', string $title = null, string $btnType = null, string $icon = null)
    {
        $this->url = $url;

        if ($title !== null) {
            $this->title = $title;
        }

        if ($btnType !== null) {
            $this->btnType = $btnType;
        }

        if ($icon !== null) {
            $this->icon = $icon;
        }
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
     * @return ButtonInterface
     */
    public function setUrl(string $url): ButtonInterface
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ButtonInterface
     */
    public function setTitle(string $title): ButtonInterface
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBtnType()
    {
        return $this->btnType;
    }

    /**
     * @param $btnType
     * @return ButtonInterface
     */
    public function setBtnType($btnType): ButtonInterface
    {
        $this->btnType = $btnType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param $icon
     * @return ButtonInterface
     */
    public function setIcon($icon): ButtonInterface
    {
        $this->icon = $icon;

        return $this;
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
     * @return ButtonInterface
     */
    public function setAttributes(array $attributes): ButtonInterface
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
     */
    protected function getClass(): string
    {
        $result = 'btn btn-' . ($this->getBtnType() ?: 'secondary');

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
            'title' => $this->getTitle(),
            'data-url' => $this->url
        ];

        if ($this->getOnClick()) {
            $result['ng-click'] = $this->getOnClick();
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function iconHtml(): string
    {
        $icon = $this->getIcon();

        return $icon ? '<i class="fa fa-' . $icon .'"></i>' : '';
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
     * @return ButtonInterface
     */
    public function setShowTitle(bool $showTitle): ButtonInterface
    {
        $this->showTitle = $showTitle;

        return $this;
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
     * @return ButtonInterface
     */
    public function setOnClick(string $onClick): ButtonInterface
    {
        $this->onClick = $onClick;

        return $this;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return ButtonInterface
     */
    public function setSize(string $size): ButtonInterface
    {
        $this->size = $size;

        return $this;
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
            $this->showTitle || !$this->getIcon() ? $this->getTitle() : ''
            );
    }

    /**
     * @param string $key
     * @param $value
     * @return ButtonInterface
     */
    public function setAttribute(string $key, $value): ButtonInterface
    {
        $this->attributes[$key] = $value;
    }
}