<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:14
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Actions\Action;

class ActionFactory
{
    /**
     * @param array $options
     * @return Action
     */
    public static function make(array $options)
    {
        $class = Action::class;

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