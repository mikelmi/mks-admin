<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 11:41
 */

namespace Mikelmi\MksAdmin\Services;


abstract class ClassFactory
{
    abstract protected static function baseClass(): string;

    abstract protected static function classInterface(): string;

    protected static $configKey = 'admin::factory.classes';

    /**
     * @param array $options
     * @return mixed
     */
    public static function make(array $options)
    {
        $baseClass = static::baseClass();

        $type = array_pull($options, 'type');

        if ($type) {
            $class = config(static::$configKey . '.' . $type, static::baseClass() . ucfirst($type));

            if (!class_exists($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' not found');
            }

            if (!static::isValidClass($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' should implement ' . static::classInterface());
            }

        } else {
            $class = $baseClass;
        }

        $instance = static::instance($class, $options);

        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($instance, $method)) {
                $instance->$method($value);
            }
        }

        return $instance;
    }

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

        return in_array(static::classInterface(), $implements);
    }

    /**
     * @param string $class
     * @param array $options
     * @return mixed
     */
    protected static function instance(string $class, array $options)
    {
        return new $class();
    }
}