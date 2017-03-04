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

    protected function cell(): string
    {
        return sprintf('<a href="%s">{{row.%s}}</a>', $this->url, $this->key);
    }
}