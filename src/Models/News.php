<?php
namespace App\Models;

/**
 * Model class representing news articles.
 *
 * @package App\Models
 */
class News extends Model
{
    /**
     * The name of the database table for news articles.
     *
     * @var string
     */
    protected $tableName = 'news';

    /**
     * News constructor.
     *
     * @param array $attributes An optional array of attributes to initialize the model with.
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Get the name of the database table associated with this model.
     *
     * @return string The table name for news articles.
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
}
