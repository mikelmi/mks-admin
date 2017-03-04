<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 16:54
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Columns\Column;
use Mikelmi\MksAdmin\DataGrid\Columns\ColumnSelect;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButton;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButtonActivate;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButtonCreate;
use Mikelmi\MksAdmin\DataGrid\Tools\GridButtonDeactivate;
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
     * @var \Illuminate\Support\Collection
     */
    private $links;

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
        $this->links = collect();
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

    /**
     * @param array $tools
     * @return $this
     */
    public function setTools(array $tools)
    {
        foreach ($tools as $tool)
        {
            if ($tool instanceof GridButton) {
                $this->tools->push($tool);
            } elseif(is_array($tool)) {
                $this->tools->push(GridButtonFactory::make($tool));
            }
        }

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getLinks(): \Illuminate\Support\Collection
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return $this
     */
    public function setLinks(array $links)
    {
        foreach ($links as $link)
        {
            if ($link instanceof GridButton) {
                $this->links->push($link);
            } elseif(is_array($link)) {
                $this->$links->push(GridButtonFactory::make($link));
            }
        }

        return $this;
    }

    /**
     * @param string $url
     * @param string|null $title
     * @return $this
     */
    public function addCreateLink(string $url, string $title = null)
    {
        return $this->addLinkButton(new GridButtonCreate($url, $title));
    }

    /**
     * @param string $url
     * @param string|null $title
     * @param string|null $confirm
     * @return $this;
     */
    public function addDeleteButton(string $url, string $title = null, string $confirm = null)
    {
        $button = new GridButtonDelete($url, $title);

        if ($confirm) {
            $button->setConfirm($confirm);
        }

        return $this->addToolButton($button);
    }

    /**
     * @param $activateUrl
     * @param $deactivateUrl
     * @return $this
     */
    public function addToggleButton($activateUrl, $deactivateUrl)
    {
        return $this->addToolButton(new GridButtonActivate($activateUrl))
                    ->addToolButton(new GridButtonDeactivate($deactivateUrl));
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

    /**
     * @param GridButton $button
     * @return $this
     */
    public function addToolButton(GridButton $button)
    {
        $this->tools->push($button);

        return $this;
    }

    /**
     * @param GridButton $button
     * @return $this
     */
    public function addLinkButton(GridButton $button)
    {
        $this->links->push($button);

        return $this;
    }

    public function response($view = null, array $data = [])
    {
        return view($view ?: 'admin::data-grid', ['grid' => $this], $data);
    }
}