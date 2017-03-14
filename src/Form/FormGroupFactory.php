<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 17:13
 */

namespace Mikelmi\MksAdmin\Form;


class FormGroupFactory
{
    public static function make($group, array $options = [], bool $withFields = true)
    {
        if (!$group instanceof FormGroup) {
            if (is_string($group)) {
                $id = $group;
                $group = new FormGroup($id);
            } elseif (is_array($group)) {
                $options = array_merge($group, $options);
                $id = array_pull($group, 'id');
                if (!$id) {
                    throw new \InvalidArgumentException("$group should contains an id");
                }
                $group = new FormGroup($id);
            } else {
                throw new \InvalidArgumentException("$group should be an array or instance of FormGroup");
            }
        }

        return static::applySetters($group, $options, $withFields);
    }

    /**
     * @param FormGroup $group
     * @param array $options
     * @param bool $withFields
     * @return FormGroup
     */
    public static function applySetters(FormGroup $group, array $options = [], bool $withFields = true): FormGroup
    {
        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            if (!$withFields && $key == 'fields') {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (is_callable([$group, $method])) {
                $group->$method($value);
            }
        }

        return $group;
    }
}