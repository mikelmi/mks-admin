<?php


namespace Mikelmi\MksAdmin\Services;


use Mikelmi\MksAdmin\Contracts\MenuManagerContract;

class SimpleMenu implements MenuManagerContract
{
    /**
     * @var array
     */
    protected $items;

    /**
     * SimpleMenu constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}