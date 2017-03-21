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
                if ($attributes[$key] === false) {
                    return $result . ' ';
                }
                if ($attributes[$key] === true) {
                    return $result . ' ' . $key;
                }
                return $result . ' ' . $key . '="' . e($attributes[$key]) . '"';
            },
            ''
        );
    }
}

if (!function_exists('hash_url')) {
    /**
     * @param $url
     * @param array ...$params
     * @return string
     */
    function hash_url($url, ...$params) {
        $result = '#/' . trim($url, '/');

        $parts = [];

        foreach ($params as $param) {
            if (is_array($param)) {
                foreach($param as $key => $value) {
                    if (is_string($key)) {
                        $parts[] = $key;
                    }
                    $parts[] = $value;
                }
            } else {
                $parts[] = $param;
            }
        }

        if ($parts) {
            $result .= '/' . implode('/', $parts);
        }

        return $result;
    }
}