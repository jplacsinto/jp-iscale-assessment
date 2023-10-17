<?php
namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Database\Database;
use App\Models\Model;
use App\Utils\Collection;

/**
 * BaseRepository is an abstract repository class that provides basic database operations.
 *
 * @package App\Repositories
 */
class BaseRepository implements BaseRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Database $db    The database connection.
     * @param Model    $model The model associated with this repository.
     */
    public function __construct(private Database $db, private Model $model)
    {
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data Data to be inserted.
     *
     * @return int The ID of the created record.
     */
    public function create(array $data): int
    {
        return $this->db->create($this->model->getTableName(), $data);
    }

    /**
     * Find a record by its ID.
     *
     * @param int $id The ID of the record to find.
     *
     * @return Model|null The found model, or null if not found.
     */
    public function findById(int $id): ?Model
    {
        $item = $this->db->read($this->model->getTableName(), $id);
        if ($item === false) {
            return null;
        }

        return $this->createModelFromData($item);
    }

    /**
     * Find all records in the table associated with the model.
     *
     * @return Collection|null A collection of models, or null if no records found.
     */
    public function findAll(): ?Collection
    {
        $items = $this->db->readAll($this->model->getTableName());
        if ($items === false) {
            return null;
        }

        $collection = new Collection();
        foreach ($items as $item) {
            $collection->add($this->createModelFromData($item));
        }
        return $collection;
    }

    /**
     * Update a record by its ID.
     *
     * @param int   $id   The ID of the record to update.
     * @param array $data Data to be updated.
     *
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(int $id, array $data): bool
    {
        $rowsAffected = $this->db->update($this->model->getTableName(), $id, $data);
        return $rowsAffected > 0;
    }

    /**
     * Delete a record by its ID.
     *
     * @param int $id The ID of the record to delete.
     *
     * @return bool True if the delete was successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $rowsAffected = $this->db->delete($this->model->getTableName(), $id);
        return $rowsAffected > 0;
    }

    /**
     * Create a model instance from data.
     *
     * @param array $data The data to populate the model.
     *
     * @return Model The created model instance.
     */
    protected function createModelFromData(array $data): Model
    {
        $model = clone $this->model;
        $model->fill($data);
        return $model;
    }
}
