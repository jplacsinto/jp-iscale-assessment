<?php
namespace App\Repositories;

use App\Database\Database;
use App\Interfaces\CommentRepositoryInterface;
use App\Models\Model;
use App\Utils\Collection;

/**
 * CommentRepository is responsible for retrieving comments associated with news articles.
 *
 * @package App\Repositories
 */
class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     *
     * @param Database $db    The database connection.
     * @param Model    $model The model associated with this repository.
     */
    public function __construct(protected Database $db, protected Model $model)
    {
    }

    /**
     * Find comments by news article ID.
     *
     * @param int $id The ID of the news article to find comments for.
     *
     * @return Collection|null A collection of comments or null if no data is found.
     */
    public function findByNewsId(int $id): ?Collection
    {
        // Get the table name for comments.
        $table = $this->model->getTableName();
        
        // Construct the SQL query to fetch comments for the specified news article.
        $query = "SELECT * FROM $table WHERE news_id = $id";

        // Execute query and check if successful.
        $items = $this->db->fetchAllFromQuery($query);
        if ($items === false) {
            return null;
        }

        // Initialize a collection to store the retrieved comments.
        $collection = new Collection();
        
        // Iterate through the fetched data and create model items for each comment.
        foreach ($items as $item) {
            $modelItem = clone $this->model;
            $modelItem->fill($item);
            $collection->add($modelItem);
        }

        // Return the collection of comments associated with the news article.
        return $collection;
    }
}
