<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:21
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Columns\Column;

class ColumnFactory
{
    /**
     * @param array $options
     * @return Column
     */
    public static function make(array $options)
    {
        $class = Column::class;

        $type = $options['type'] ?? '';

        if ($type) {
            $class .= ucfirst($type);

            if (!class_exists($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' not found');
            }
        }

        $column = new $class($options['key'] ?? '');

        unset($options['type'], $options['key']);

        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($column, $method)) {
                $column->$method($value);
            }
        }

        return $column;
    }
}