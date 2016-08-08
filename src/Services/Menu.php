<?php


namespace Mikelmi\MksAdmin\Services;


use Mikelmi\MksAdmin\Contracts\MenuManagerContract;

class Menu implements MenuManagerContract
{
    protected $items;

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