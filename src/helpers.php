<?php
/**
 * Author: mike
 * Date: 03.03.17
 * Time: 15:00
 */

if (!function_exists('html_attr')) {

    /**
     * @param array $attributes
     * @return string
     */
    function html_attr(array $attributes) : string
    {
        return array_reduce(
            array_keys($attributes),
            function ($result, $key) use ($attributes) {
                return $result . ' ' . $key . '="' . e($attributes[$key]) . '"';
            },
            ''
        );
    }
}