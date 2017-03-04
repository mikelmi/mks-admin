<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:46
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


use Mikelmi\MksAdmin\DataGrid\Actions\Action;

class ColumnActions extends Column
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $actions;

    public function __construct($key, $title, $sortable = false, $searchable = false)
    {
        parent::__construct($key, $title, $sortable, $searchable);

        $this->actions = collect();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getActions(): \Illuminate\Support\Collection
    {
        return $this->actions;
    }

    /**
     * @param Action $action
     * @return $this
     */
    public function addAction(Action $action)
    {
        $this->actions->push($action);
        return $this;
    }

    public function renderHead()
    {
        $attr = [
            'class' => 'st-actions'
        ];

        return sprintf('<th%s> </th>', html_attr($attr));
    }

    public function renderSearch(): string
    {
        return '<th> </th>';
    }

    protected function cell(): string
    {
        $result = '<div class="btn-group btn-group-sm">';

        /** @var Action $action */
        foreach ($this->actions as $action) {
            $result .= $action->render() . "\n";
        }

        return $result . '</div>';
    }
}