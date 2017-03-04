<?php
/**
 * Author: mike
 * Date: 03.03.17
 * Time: 15:52
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnStatus extends Column
{
    /**
     * @var array
     */
    protected $options = [];

    /** @var string */
    protected $url;

    /**
     * @var string
     */
    protected $actionTitle;

    protected $cellAttributes = ['class' => 'text-center'];

    protected $headAttributes = ['class' => 'text-center'];

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        if (!$this->options) {
            $this->options = [
                '1' => trans('admin::messages.Active'),
                '0' => trans('admin::messages.Inactive'),
            ];
        }

        return $this->options;
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
     * @return string
     */
    public function getActionTitle(): string
    {
        return $this->actionTitle;
    }

    /**
     * @param string $actionTitle
     * @return $this
     */
    public function setActionTitle(string $actionTitle)
    {
        $this->actionTitle = $actionTitle;

        return $this;
    }

    public function renderSearch(): string
    {
        $input = '';

        if ($this->searchable) {
            $attr = [
                'st-search' => $this->key,
                'class' => 'form-control form-control-sm form-block',
                'placeholder' => $this->title,
            ];

            $input = '<select ' . html_attr($attr) . '>';
            $input .= '<option value=""></option>';

            foreach($this->getOptions() as $key => $label) {
                $input .= '<option value="' . $key . '">' . $label . '</option>';
            }

            $input .= '</select>';
        }

        return sprintf('<th>%s</th>', $input);
    }

    public function cell(): string
    {
        $icon = sprintf('<i class="fa" ng-class="{\'fa-check\':row.%s,\'fa-minus\':!row.%1$s}"></i>', $this->key);

        if ($this->url) {
            $attr = [
                'class' => 'btn btn-sm',
                'ng-class' => sprintf('{\'btn-success\':row.%s,\'btn-warning\':!row.%1$s}', $this->key),
                'ng-click' => "grid.updateRow(row, '" . $this->url . "/'+row.id)",
                'title' => $this->actionTitle ?: (trans('admin::messages.Activate').'/'.trans('admin::messages.Deactivate')),
            ];

            return sprintf('<button %s>%s</button>', html_attr($attr), $icon);
        }

        $attr = [
            'class' => 'badge',
            'ng-class' => sprintf('{\'badge-success\':row.%s,\'badge-warning\':!row.%1$s}', $this->key),
        ];

        return sprintf('<badge %s>%s</badge>', html_attr($attr), $icon);
    }
}