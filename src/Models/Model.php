<?php

namespace App\Models;

/**
 * Base class for models.
 */
abstract class Model
{
    /**
     * @var array The attributes of the model.
     */
    private $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Get the value of an attribute.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Set the value of an attribute.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute(string $key, $value)
    {
        // Add validation and sanitization logic if needed.
        $this->attributes[$key] = $value;
    }

    /**
     * Get an array representation of the model's attributes.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Get the table name associated with this model.
     *
     * @return string
     */
    abstract public function getTableName(): string;
}
