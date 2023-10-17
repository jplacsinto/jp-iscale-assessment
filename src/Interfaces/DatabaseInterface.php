<?php
namespace App\Interfaces;

/**
 * Interface DatabaseInterface
 *
 * This interface defines the contract for a database interaction layer.
 *
 * @package App\Interfaces
 */
interface DatabaseInterface {
    /**
     * Create a new record in the database.
     *
     * @param string $table The name of the table to insert data into.
     * @param array  $data  Data to be inserted.
     *
     * @return int The ID of the created record.
     */
    public function create(string $table, array $data): int;

    /**
     * Read a record by its ID from the database.
     *
     * @param string $table The name of the table to read data from.
     * @param int    $id    The ID of the record to find.
     *
     * @return array|null The found data, or null if not found.
     */
    public function read(string $table, int $id): ?array;

    /**
     * Read all records from the database for a specific table.
     *
     * @param string $table The name of the table to read data from.
     *
     * @return array|null An array of records, or null if no records are found.
     */
    public function readAll(string $table): ?array;

    /**
     * Update a record in the database by its ID.
     *
     * @param string $table The name of the table to update data in.
     * @param int    $id    The ID of the record to update.
     * @param array  $data  Data to be updated.
     *
     * @return int The number of rows affected by the update operation.
     */
    public function update(string $table, int $id, array $data): int;

    /**
     * Delete a record from the database by its ID.
     *
     * @param string $table The name of the table to delete data from.
     * @param int    $id    The ID of the record to delete.
     *
     * @return int The number of rows affected by the delete operation.
     */
    public function delete(string $table, int $id): int;
}
