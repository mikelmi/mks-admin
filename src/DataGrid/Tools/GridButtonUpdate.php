<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 19:56
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonUpdate extends GridButton
{
    public function getOnClick(): string
    {
        if ($this->onClick === null) {
            $this->onClick = sprintf("grid.updateSelected('%s')", $this->url);
        }

        return $this->onClick;
    }
}