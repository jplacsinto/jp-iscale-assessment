<?php
namespace App\Interfaces;

use App\Models\Model;
use App\Utils\Collection;

/**
 * Interface BaseRepositoryInterface
 *
 * This interface defines the contract for a generic repository that can interact with models and a database.
 *
 * @package App\Interfaces
 */
interface BaseRepositoryInterface {
    /**
     * Create a new record in the database.
     *
     * @param array $data Data to be inserted.
     *
     * @return int The ID of the created record.
     */
    public function create(array $data): int;

    /**
     * Find a record by its ID.
     *
     * @param int $id The ID of the record to find.
     *
     * @return Model|null The found model, or null if not found.
     */
    public function findById(int $id): ?Model;

    /**
     * Find all records in the table associated with the model.
     *
     * @return Collection|null A collection of models, or null if no records found.
     */
    public function findAll(): ?Collection;

    /**
     * Update a record by its ID.
     *
     * @param int   $id   The ID of the record to update.
     * @param array $data Data to be updated.
     *
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a record by its ID.
     *
     * @param int $id The ID of the record to delete.
     *
     * @return bool True if the delete was successful, false otherwise.
     */
    public function delete(int $id): bool;
}
