<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:46
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


use Mikelmi\MksAdmin\DataGrid\ActionFactory;
use Mikelmi\MksAdmin\DataGrid\Actions\Action;

class ColumnActions extends Column
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $actions;

    public function __construct($key, $title = null, $sortable = false, $searchable = false)
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

    /**
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        foreach ($actions as $action)
        {
            if ($action instanceof Action) {
                $this->actions->push($action);
            } elseif(is_array($action)) {
                $this->actions->push(ActionFactory::make($action));
            }
        }

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