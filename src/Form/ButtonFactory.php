<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 11:15
 */

namespace Mikelmi\MksAdmin\Form;


use Mikelmi\MksAdmin\Services\ClassFactory;

/**
 * Class ButtonFactory
 * @package Mikelmi\MksAdmin\Form
 *
 * @method static make(array $options): ButtonInterface
 */
class ButtonFactory extends ClassFactory
{
    protected static $configKey = 'admin.form.buttons';

    /**
     * @return string
     */
    protected static function baseClass(): string
    {
        return Button::class;
    }

    /**
     * @return string
     */
    protected static function classInterface(): string
    {
        return ButtonInterface::class;
    }
}