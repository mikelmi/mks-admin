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
        $baseClass = Action::class;

        $type = array_pull($options, 'type');

        if ($type) {
            $class = config('admin::datagrid.actions.'.$type, $baseClass . ucfirst($type));

            if (!class_exists($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' not found');
            }
        } else {
            $class = $baseClass;
        }

        $action = new $class();

        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($action, $method)) {
                $action->$method($value);
            }
        }

        return $action;
    }
}