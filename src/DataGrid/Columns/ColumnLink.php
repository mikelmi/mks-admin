<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 18:58
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnLink extends Column
{
    /**
     * @var string
     */
    private $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ColumnLink
     */
    public function setUrl(string $url): ColumnLink
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    protected function cell(): string
    {
        $attr = array_merge([
            'href' => $this->getUrl()
        ], $this->getAttributes());

        return sprintf('<a %s>{{row.%s}}</a>', html_attr($attr), $this->key);
    }
}