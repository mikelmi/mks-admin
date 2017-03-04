<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:25
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonLink extends GridButton
{
    protected $showTitle = true;

    public function defaultAttributes(): array
    {
        return [
            'class' => $this->getClass(),
            'title' => $this->getTitle(),
            'href' => $this->url,
        ];
    }

    public function render(): string
    {
        $attr = array_merge($this->defaultAttributes(), $this->getAttributes());

        return sprintf(
            '<a %s>%s %s</a>',
            html_attr($attr),
            $this->iconHtml(),
            $this->showTitle || !$this->getIcon() ? $this->getTitle() : ''
        );
    }
}