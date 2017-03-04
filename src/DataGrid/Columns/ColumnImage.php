<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:04
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnImage extends Column
{
    /**
     * @var string
     */
    private $src;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @return string
     */
    public function getSrc(): string
    {
        if (!$this->src) {
            $this->src = '{{row.' . $this->key . '}}';
        }

        return $this->src;
    }

    /**
     * @param string $src
     * @return ColumnImage
     */
    public function setSrc(string $src): ColumnImage
    {
        $this->src = $src;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return ColumnImage
     */
    public function setWidth(int $width): ColumnImage
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return ColumnImage
     */
    public function setHeight(int $height): ColumnImage
    {
        $this->height = $height;
        return $this;
    }



    protected function cell(): string
    {
        $styles = '';

        if ($this->width || $this->height) {
            $styles = ' style="';
            if ($this->width) {
                $styles .= 'width: '.$this->width . 'px;';
            }
            if ($this->height) {
                $styles .= 'height: '.$this->height . 'px;';
            }
            $styles .= '"';
        }

        return sprintf(
            '<div ng-if="row.%s"%s>
                 <img alt="" ng-src="%s" class="img-thumbnail img-fluid" />
            </div>',
            $this->key,
            $styles,
            $this->getSrc()
        );
    }
}