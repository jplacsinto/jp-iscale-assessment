<?php
namespace App\Models;

/**
 * Comment model representing comments in the database.
 *
 * @package App\Models
 */
class Comment extends Model
{
    /**
     * The name of the database table associated with the Comment model.
     *
     * @var string
     */
    protected $tableName = 'comment';

    /**
     * Comment constructor.
     *
     * @param array $attributes An array of attributes to fill the Comment model with.
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Get the name of the database table associated with the Comment model.
     *
     * @return string The table name.
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
}
