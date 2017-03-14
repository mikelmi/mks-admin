<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 12:09
 */

namespace Mikelmi\MksAdmin\Form;


class FieldFactory
{
    /**
     * @param string $class
     * @return bool
     */
    protected static function isValidClass(string $class): bool
    {
        static $implements;

        if (!isset($implements)) {
            $implements = class_implements($class);
        }

        return in_array(FieldInterface::class, $implements);
    }

    /**
     * @param string $type
     * @param array $options
     * @return FieldInterface
     */
    public static function make(string $type, array $options = [])
    {
        $class = config('admin.form.fields.' . $type);

        if (!$class) {
            $class = __NAMESPACE__ . '\\Field\\' . ucfirst($type);
        }

        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Class ' . $class . ' not found');
        }

        if (!static::isValidClass($class)) {
            throw new \InvalidArgumentException('Class ' . $class . ' should implement ' . FieldInterface::class);
        }

        return static::applySetters(new $class, $options);
    }

    /**
     * @param FieldInterface $field
     * @param array $options
     * @return FieldInterface
     */
    public static function applySetters(FieldInterface $field, array $options)
    {
        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($field, $method)) {
                $field->$method($value);
            } elseif (!is_array($value)) {
                $field->setAttribute($key, $value);
            }
        }

        return $field;
    }
}