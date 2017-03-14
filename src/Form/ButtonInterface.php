<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 10:48
 */

namespace Mikelmi\MksAdmin\Form;


interface ButtonInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     * @return ButtonInterface
     */
    public function setUrl(string $url): self;

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @param string $title
     * @return ButtonInterface
     */
    public function setTitle(string $title): self;

    /**
     * @return null|string
     */
    public function getBtnType();

    /**
     * @param $btnType
     * @return ButtonInterface
     */
    public function setBtnType($btnType): self;

    /**
     * @return null|string
     */
    public function getIcon();

    /**
     * @param $icon
     * @return ButtonInterface
     */
    public function setIcon($icon): self;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param array $attributes
     * @return ButtonInterface
     */
    public function setAttributes(array $attributes): self;

    /**
     * @param string $key
     * @param $value
     * @return ButtonInterface
     */
    public function setAttribute(string $key, $value): self;

    /**
     * @return bool
     */
    public function isShowTitle(): bool;

    /**
     * @param bool $showTitle
     * @return ButtonInterface
     */
    public function setShowTitle(bool $showTitle): self;

    /**
     * @return string
     */
    public function getOnClick(): string;

    /**
     * @param string $onClick
     * @return ButtonInterface
     */
    public function setOnClick(string $onClick): self;

    /**
     * @return string
     */
    public function getSize(): string;

    /**
     * @param string $size
     * @return ButtonInterface
     */
    public function setSize(string $size): self;


    /**
     * @return string
     */
    public function render(): string;
}