<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 16:54
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Columns\Column;
use Mikelmi\MksAdmin\DataGrid\Columns\ColumnSelect;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButtonAdd;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButtonDelete;

class DataGrid
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $tools;

    /**
     * @var GridButtonAdd|null
     */
    private $addButton;

    /**
     * @var GridButtonDelete|null
     */
    private $deleteButton;

    /**
     * @var bool
     */
    private $withSearch = true;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $columns;

    /**
     * @var bool
     */
    private $selectable;

    /**
     * @var int
     */
    private $perPage = 10;

    /**
     * @var array
     */
    private $rowAttributes = [];

    /**
     * DataGrid constructor.
     * @param string $url
     * @param string|null $title
     * @param bool $selectable
     */
    public function __construct(string $url, string $title = null, bool $selectable = true)
    {
        $this->url = $url;
        $this->title = $title;
        $this->tools = collect();
        $this->columns = collect();
        $this->setSelectable($selectable);
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
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTools(): \Illuminate\Support\Collection
    {
        return $this->tools;
    }

    public function renderAddButton()
    {
        return $this->addButton ? $this->addButton->render() : '';
    }

    public function renderDeleteButton()
    {
        return $this->deleteButton ? $this->deleteButton->render() : '';
    }

    /**
     * @param string $url
     * @param string|null $title
     * @return $this
     */
    public function setAddButton(string $url, string $title = null)
    {
        $this->addButton = new GridButtonAdd($url, $title);

        return $this;
    }

    /**
     * @param string $url
     * @param string|null $title
     * @param string|null $confirm
     * @return $this;
     */
    public function setDeleteButton(string $url, string $title = null, string $confirm = null)
    {
        $this->deleteButton = new GridButtonDelete($url);

        if ($confirm) {
            $this->deleteButton->setConfirm($confirm);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithSearch(): bool
    {
        return $this->withSearch;
    }

    /**
     * @param bool $withSearch
     * @return $this
     */
    public function setWithSearch(bool $withSearch)
    {
        $this->withSearch = $withSearch;

        return $this;
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function addColumn(Column $column)
    {
        $this->columns->push($column);

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelectable(): bool
    {
        return $this->selectable;
    }

    /**
     * @param bool $selectable
     * @return DataGrid
     */
    public function setSelectable(bool $selectable): DataGrid
    {
        if ($selectable) {
            $this->columns->prepend(new ColumnSelect('', ''));
        } else if ($this->selectable === true) {
            $this->columns->shift();
        }

        $this->selectable = $selectable;

        return $this;
    }

    /**
     * @return array
     */
    public function getRowAttributes(): array
    {
        return $this->rowAttributes;
    }

    /**
     * @param array $rowAttributes
     * @return DataGrid
     */
    public function setRowAttributes(array $rowAttributes): DataGrid
    {
        $this->rowAttributes = $rowAttributes;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasSortableColumns(): bool
    {
        //TODO: check if grid has sortable columns
        return true;
    }

    /**
     * @return bool
     */
    public function hasSearchableColumns(): bool
    {
        //TODO: check if grid has searchable columns
        return true;
    }

    public function response($view = null, array $data = [])
    {
        return view($view ?: 'admin::data-grid', ['grid' => $this], $data);
    }
}