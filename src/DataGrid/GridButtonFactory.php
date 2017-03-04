<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 20:23
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Tools\GridButton;

class GridButtonFactory
{
    /**
     * @param array $options
     * @return GridButton
     */
    public static function make(array $options)
    {
        $class = GridButton::class;

        $type = $options['type'] ?? '';

        if ($type) {
            $class .= ucfirst($type);

            if (!class_exists($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' not found');
            }
        }

        $button = new $class();

        unset($options['type']);

        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($button, $method)) {
                $button->$method($value);
            }
        }

        return $button;
    }
}