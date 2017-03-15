<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:54
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


class ActionLink extends Action
{
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

        return sprintf(
            '<a %s>%s %s</a>',
            html_attr($attr),
            $this->iconHtml(),
            $this->showTitle || !$this->getIcon() ? e($this->getTitle()) : ''
        );
    }
}