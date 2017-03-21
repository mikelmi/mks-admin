<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 12:09
 */

namespace Mikelmi\MksAdmin\Form;


interface FieldInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return FieldInterface
     */
    public function setName(string $name): FieldInterface;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $label
     * @return FieldInterface
     */
    public function setLabel(string $label): FieldInterface;

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @param bool $required
     * @return FieldInterface
     */
    public function setRequired(bool $required): FieldInterface;

    /**
     * @return bool
     */
    public function isReadOnly(): bool;

    /**
     * @param bool $readOnly
     * @return FieldInterface
     */
    public function setReadOnly(bool $readOnly): FieldInterface;

    /**
     * @return bool
     */
    public function isDisabled(): bool;

    /**
     * @param bool $disabled
     * @return FieldInterface
     */
    public function setDisabled(bool $disabled): FieldInterface;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param array $attributes
     * @return FieldInterface
     */
    public function setAttributes(array $attributes): FieldInterface;

    /**
     * @param string $key
     * @param null $value
     * @return FieldInterface
     */
    public function setAttribute(string $key, $value = null): FieldInterface;

    /**
     * @return string
     */
    public function getLayout(): string;

    /**
     * @param string $layout
     * @return FieldInterface
     */
    public function setLayout(string $layout): FieldInterface;

    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @param string $template
     * @return FieldInterface
     */
    public function setTemplate(string $template): FieldInterface;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     * @return FieldInterface
     */
    public function setId(string $id): FieldInterface;

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @param string $class
     * @return FieldInterface
     */
    public function setClass(string $class): FieldInterface;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return FieldInterface
     */
    public function setValue($value): FieldInterface;

    /**
     * @return string
     */
    public function render():string;

    /**
     * @return string
     */
    public function renderInput(): string;

    /**
     * @return string
     */
    public function renderStaticInput(): string;

    /**
     * @return string
     */
    public function getNameSce(): string;

    /**
     * @param string $nameSce
     * @return FieldInterface
     */
    public function setNameSce(string $nameSce): FieldInterface;

    public function isStatic(): bool;

    /**
     * @param bool $static
     * @return FieldInterface
     */
    public function setStatic(bool $static): FieldInterface;

    public function renderField(): string;
}