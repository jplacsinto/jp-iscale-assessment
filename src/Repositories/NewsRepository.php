<?php
namespace App\Repositories;

use App\Databases\Database;
use App\Interfaces\NewsRepositoryInterface;
use App\Models\Model;
use App\Utils\Collection;
use App\Models\Comment;

/**
 * NewsRepository is responsible for retrieving news articles along with their associated comments.
 *
 * @package App\Repositories
 */
class NewsRepository extends BaseRepository implements NewsRepositoryInterface
{
    /**
     * NewsRepository constructor.
     *
     * @param Database $db    The database connection.
     * @param Model    $model The model associated with this repository.
     */
    public function __construct(protected Database $db, protected Model $model)
    {
    }
    
    /**
     * Retrieve all news articles along with their associated comments.
     *
     * @return Collection|null A collection of news articles with comments or null if no data is found.
     */
    public function findAllWithComments(): ?Collection
    {
        // Get the table name for news and comments.
        $table = $this->model->getTableName();
        $commentTable = (new Comment())->getTableName();

        // Construct the SQL query to fetch news articles and their associated comments.
        $query = "SELECT news.*, 
                 comments.id as comments_id,
                 comments.body as comments_body,
                 comments.created_at as comments_created_at
                 FROM $table 
                 LEFT JOIN $commentTable as comments
                 ON comments.news_id = $table.id";

        // Execute query and check if successful.
        $items = $this->db->fetchAllFromQuery($query);
        if ($items === false) {
            return null;
        }

        // Initialize an array to organize news articles and their comments.
        $newsItem = [];
        $collection = new Collection();

        // Iterate through the fetched data and organize it into the desired structure.
        foreach ($items as $item) {
            $newsItem[$item['id']]['id'] = $item['id'];
            $newsItem[$item['id']]['title'] = $item['title'];
            $newsItem[$item['id']]['body'] = $item['body'];
            $newsItem[$item['id']]['created_at'] = $item['created_at'];
            $newsItem[$item['id']]['comments'][] = [
                'id' => $item['comments_id'],
                'body' => $item['comments_body'],
                'created_at' => $item['comments_created_at']
            ];
        }

        // Create a new model item from the organized data and add it to the collection.
        $modelItem = clone $this->model;
        $modelItem->fill($newsItem);
        $collection->add($modelItem);

        // Return the collection of news articles with comments.
        return $collection;
    }
}
