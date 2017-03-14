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
     * @var array
     */
    protected $buttonAttributes = [];

    /**
     * @param array $options
     * @return ColumnStatus
     */
    public function setOptions(array $options): ColumnStatus
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
                '1' => __('admin::messages.Active'),
                '0' => __('admin::messages.Inactive'),
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
     * @return ColumnStatus
     */
    public function setUrl(string $url): ColumnStatus
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
     * @return ColumnStatus
     */
    public function setActionTitle(string $actionTitle): ColumnStatus
    {
        $this->actionTitle = $actionTitle;

        return $this;
    }

    /**
     * @return array
     */
    public function getButtonAttributes(): array
    {
        return $this->buttonAttributes;
    }

    /**
     * @param array $buttonAttributes
     * @return ColumnStatus
     */
    public function setButtonAttributes(array $buttonAttributes): ColumnStatus
    {
        $this->buttonAttributes = $buttonAttributes;
        return $this;
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

    /**
     * @return string
     */
    public function cell(): string
    {
        $icon = sprintf('<i class="fa" ng-class="{\'fa-check\':row.%s,\'fa-minus\':!row.%1$s}"></i>', $this->key);

        if ($this->url) {
            $attr = array_merge([
                'class' => 'btn btn-sm',
                'ng-class' => sprintf('{\'btn-success\':row.%s,\'btn-warning\':!row.%1$s}', $this->key),
                'ng-click' => "grid.updateRow(row, '" . $this->url . "/'+row.id)",
                'title' => $this->actionTitle ?: (__('admin::messages.Activate').'/'.__('admin::messages.Deactivate')),
            ], $this->buttonAttributes);

            return sprintf('<button %s>%s</button>', html_attr($attr), $icon);
        }

        $attr = [
            'class' => 'badge',
            'ng-class' => sprintf('{\'badge-success\':row.%s,\'badge-warning\':!row.%1$s}', $this->key),
        ];

        return sprintf('<badge %s>%s</badge>', html_attr($attr), $icon);
    }
}