<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 18:34
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class Column
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var bool
     */
    protected $sortable;

    /**
     * @var bool
     */
    protected $searchable;

    /**
     * @var string
     */
    protected $searchType = 'search';

    /**
     * @var array
     */
    protected $cellAttributes = [];

    /**
     * @var array
     */
    protected $headAttributes = [];

    /**
     * Column constructor.
     * @param string $key
     * @param string $title
     * @param bool $sortable
     * @param bool $searchable
     */
    public function __construct(string $key, string $title = null, bool $sortable = false, bool $searchable = false)
    {
        $this->key = $key;
        $this->title = $title;
        $this->sortable = $sortable;
        $this->searchable = $searchable;

        if ($title !== null) {
            $this->title = $title;
        } elseif (!$this->title) {
            $this->title = ucwords($this->key);
        }
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;

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
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param bool $sortable
     * @return $this
     */
    public function setSortable(bool $sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * @param bool $searchable
     * @return $this
     */
    public function setSearchable(bool $searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * @return array
     */
    public function getCellAttributes(): array
    {
        return $this->cellAttributes;
    }

    /**
     * @param array $cellAttributes
     * @return $this
     */
    public function setCellAttributes(array $cellAttributes)
    {
        $this->cellAttributes = $cellAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeadAttributes(): array
    {
        return $this->headAttributes;
    }

    /**
     * @param array $headAttributes
     * @return $this
     */
    public function setHeadAttributes(array $headAttributes)
    {
        $this->headAttributes = $headAttributes;

        return $this;
    }

    /**
     * @return string
     */
    public function getSearchType(): string
    {
        return $this->searchType;
    }

    /**
     * @param string $searchType
     * @return Column
     */
    public function setSearchType(string $searchType): Column
    {
        $this->searchType = $searchType;
        return $this;
    }

    public function renderHead()
    {
        $attr = [];

        $class = '';

        if ($this->sortable) {
            $attr['st-sort'] = $this->key;
            $class = 'st-sortable';
        }

        $attr = array_merge($attr, $this->headAttributes);

        if ($class) {
            $attr['class'] = $class . ' ' . array_get($attr, 'class');
        }

        return sprintf('<th%s>%s</th>', html_attr($attr), $this->title);
    }

    public function renderSearch(): string
    {
        $input = '';

        if ($this->searchable) {
            $attr = [
                'st-search' => $this->key,
                'class' => 'form-control form-control-sm form-block',
                'type' => $this->getSearchType(),
                'placeholder' => $this->title,
            ];

            $input = sprintf('<input %s />', html_attr($attr));
        }

        return sprintf('<th>%s</th>', $input);
    }

    protected function cell(): string
    {
        return '{{row.'. $this->key .'}}';
    }

    public function renderCell(): string
    {
        return sprintf('<td%s>%s</td>', html_attr($this->cellAttributes), $this->cell());
    }
}