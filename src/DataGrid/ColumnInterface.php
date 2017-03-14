<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 11:21
 */

namespace Mikelmi\MksAdmin\DataGrid;


interface ColumnInterface
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $key
     * @return ColumnInterface
     */
    public function setKey(string $key): self;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return ColumnInterface
     */
    public function setTitle(string $title): self;

    /**
     * @return bool
     */
    public function isSortable(): bool;

    /**
     * @param bool $sortable
     * @return ColumnInterface
     */
    public function setSortable(bool $sortable): self;

    /**
     * @return bool
     */
    public function isSearchable(): bool;

    /**
     * @param bool $searchable
     * @return ColumnInterface
     */
    public function setSearchable(bool $searchable): self;

    /**
     * @return array
     */
    public function getCellAttributes(): array;

    /**
     * @param array $cellAttributes
     * @return ColumnInterface
     */
    public function setCellAttributes(array $cellAttributes): self;

    /**
     * @return array
     */
    public function getHeadAttributes(): array;

    /**
     * @param array $headAttributes
     * @return ColumnInterface
     */
    public function setHeadAttributes(array $headAttributes): self;

    /**
     * @return string
     */
    public function getSearchType(): string;

    /**
     * @param string $searchType
     * @return ColumnInterface
     */
    public function setSearchType(string $searchType): self;

    /**
     * @return string
     */
    public function renderHead(): string;

    /**
     * @return string
     */
    public function renderSearch(): string;

    /**
     * @return string
     */
    public function renderCell(): string;
}