<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 11:09
 */

namespace Mikelmi\MksAdmin\DataGrid;


class Scope
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $badge;

    /**
     * Scope constructor.
     * @param string $name
     * @param string $title
     * @param string $badge
     */
    public function __construct(string $name = '', string $title = '', string $badge = '')
    {
        $this->title = $title;
        $this->setName($name);
        $this->badge = $badge;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?: '';
    }

    /**
     * @param string $name
     * @return Scope
     */
    public function setName(string $name): Scope
    {
        $this->name = $name;

        if (!$this->title) {
            $this->title = ucwords($name);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title ?: '';
    }

    /**
     * @param string $title
     * @return Scope
     */
    public function setTitle(string $title): Scope
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon ?: '';
    }

    /**
     * @param string $icon
     * @return Scope
     */
    public function setIcon(string $icon): Scope
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getBadge(): string
    {
        return $this->badge ?: '';
    }

    /**
     * @param string $badge
     * @return Scope
     */
    public function setBadge(string $badge): Scope
    {
        $this->badge = $badge;
        return $this;
    }

    /**
     * @param array $options
     * @return Scope
     */
    public function applySetters(array $options): Scope
    {
        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }

        return $this;
    }
}