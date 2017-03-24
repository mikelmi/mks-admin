<?php
/**
 * Author: mike
 * Date: 03.03.17
 * Time: 15:52
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnStatus extends ColumnList
{

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
    public function cell(): string
    {
        $icon = sprintf('<i class="fa fa-lg" ng-class="{\'fa-toggle-on\':row.%s,\'fa-toggle-off\':!row.%1$s}"></i>', $this->key);

        if ($this->url) {
            $attr = array_merge([
                'class' => 'btn btn-sm btn-link no-b',
                'type' => 'button',
                'ng-class' => sprintf('{\'text-success\':row.%s,\'text-danger\':!row.%1$s}', $this->key),
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

    /**
     * @param bool $disabled
     * @return ColumnStatus
     */
    public function setDisabled(bool $disabled): ColumnStatus
    {
        $this->buttonAttributes['disabled'] = $disabled;
        return $this;
    }

    /**
     * @param string $disabled
     * @return ColumnStatus
     */
    public function setNgDisabled(string $disabled): ColumnStatus
    {
        $this->buttonAttributes['ng-disabled'] = $disabled;
        return $this;
    }
}