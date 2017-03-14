<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 18:45
 */

namespace Mikelmi\MksAdmin\Form;


class ButtonLink extends Button
{
    protected $showTitle = true;

    protected $btnType = 'link';

    /**
     * @return array
     */
    public function defaultAttributes(): array
    {
        return [
            'class' => $this->getClass(),
            'title' => $this->getTitle(),
            'href' => $this->url,
        ];
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $attr = array_merge($this->defaultAttributes(), $this->getAttributes());

        $title = '';

        if ($this->showTitle || !$this->getIcon()) {
            $title = $this->getTitle();
            if (!$title && !$this->getIcon()) {
                $title = $this->getUrl();
            }
        }

        return sprintf(
            '<a %s>%s %s</a>',
            html_attr($attr),
            $this->iconHtml(),
            $title
        );
    }
}