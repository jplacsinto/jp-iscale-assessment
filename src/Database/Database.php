<?php

/**
 * @todo: add error handling
 */
namespace App\Database;

use PDO;
use PDOException;
use App\Interfaces\DatabaseInterface;

/**
 * A database class that provides basic database operations.
 */
class Database implements DatabaseInterface
{
    /**
     * @var PDO The PDO instance for database connection.
     */
    private PDO $db;

    /**
     * Constructor to initialize the database connection.
     *
     * @param array $config An array of database connection configuration (host, dbname, username, password).
     */
    public function __construct(array $config)
    {
        $this->connect($config);
    }

    /**
     * Connect to the database using the provided configuration.
     *
     * @param array $config An array of database connection configuration (host, dbname, username, password).
     *
     * @throws \RuntimeException If the database connection fails.
     */
    private function connect(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        try {
            $this->db = new PDO($dsn, $config['username'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the PDO database connection instance.
     *
     * @return PDO The PDO instance for database connection.
     */
    public function getConnection(): PDO
    {
        return $this->db;
    }

    /**
     * Create a new record in the database table.
     *
     * @param string $table The name of the table.
     * @param array $data An associative array of data to insert.
     *
     * @return int The ID of the newly created record.
     */
    public function create(string $table, array $data): int
    {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($keys) VALUES ($values)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Read a record from the database table by ID.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record to retrieve.
     *
     * @return array|null An associative array representing the record, or null if not found.
     */
    public function read(string $table, int $id): ?array
    {
        $query = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Read all records from the database table.
     *
     * @param string $table The name of the table.
     *
     * @return array|null An array of associative arrays representing the records, or null if there are no records.
     */
    public function readAll(string $table): ?array
    {
        $query = "SELECT * FROM $table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update a record in the database table by ID.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record to update.
     * @param array $data An associative array of data to update.
     *
     * @return int The number of rows affected by the update.
     */
    public function update(string $table, int $id, array $data): int
    {
        $updateData = [];
        foreach ($data as $key => $value) {
            $updateData[] = "$key = :$key";
        }
        $updateString = implode(', ', $updateData);
        $query = "UPDATE $table SET $updateString WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return (int)$stmt->rowCount();
    }

    /**
     * Delete a record from the database table by ID.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record to delete.
     *
     * @return int The number of rows affected by the delete operation.
     */
    public function delete(string $table, int $id): int
    {
        $query = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->rowCount();
    }

    /**
     * Execute a custom query and fetch all results.
     *
     * @param string $query The SQL query to execute.
     *
     * @return array|null An array of associative arrays representing the query results, or null if there are no results.
     */
    public function fetchAllFromQuery(string $query): ?array
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

