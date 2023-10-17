<?php
namespace App\Utils;

use App\Models\Model;

/**
 * A collection for storing and retrieving model items.
 *
 * @package App\Utils
 */
class Collection
{
    /**
     * @var Model[] An array to store model items.
     */
    private array $items = [];

    /**
     * Add a model item to the collection.
     *
     * @param Model $modelItem The model item to add to the collection.
     */
    public function add(Model $modelItem)
    {
        $this->items[] = $modelItem;
    }

    /**
     * Get all model items from the collection.
     *
     * @return Model[] An array of model items in the collection.
     */
    public function getAll(): array
    {
        return $this->items;
    }
}
