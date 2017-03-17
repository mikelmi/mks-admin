<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 18:34
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


use Mikelmi\MksAdmin\DataGrid\ColumnInterface;

class Column implements ColumnInterface
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
     * @var array
     */
    protected $attributes = [];

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
     * @return ColumnInterface
     */
    public function setKey(string $key): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setTitle(string $title): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setSortable(bool $sortable): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setSearchable(bool $searchable): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setCellAttributes(array $cellAttributes): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setHeadAttributes(array $headAttributes): ColumnInterface
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
     * @return ColumnInterface
     */
    public function setSearchType(string $searchType): ColumnInterface
    {
        $this->searchType = $searchType;
        return $this;
    }

    /**
     * @return string
     */
    public function renderHead(): string
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

        return sprintf('<th%s>%s</th>', html_attr($attr), e($this->title));
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    protected function cell(): string
    {
        return '{{row.'. $this->key .'}}';
    }

    /**
     * @return string
     */
    public function renderCell(): string
    {
        return sprintf('<td%s>%s</td>', html_attr($this->cellAttributes), $this->cell());
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
     * @return ColumnLink
     */
    public function setAttributes(array $attributes): ColumnLink
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return ColumnLink
     */
    public function setAttribute(string $name, $value): ColumnLink
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    function __call($name, $arguments)
    {
        if (strpos($name, 'set') !== false) {
            $prop = lcfirst(preg_replace('/^set/', '', $name));
            if ($prop) {
                $arg = $arguments;
                array_unshift($arg, $prop);
                return call_user_func_array([$this, 'setAttribute'], $arg);
            }
        }

        throw new \LogicException("Method $name not found");
    }
}