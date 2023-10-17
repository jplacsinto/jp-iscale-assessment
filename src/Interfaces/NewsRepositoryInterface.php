<?php
namespace App\Interfaces;

use App\Utils\Collection;

/**
 * Interface NewsRepositoryInterface
 *
 * This interface extends the BaseRepositoryInterface and defines the contract for a repository that interacts with news articles, including retrieving articles along with their associated comments.
 *
 * @package App\Interfaces
 */
interface NewsRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Retrieve all news articles along with their associated comments.
     *
     * @return Collection|null A collection of news articles with comments or null if no data is found.
     */
    public function findAllWithComments(): ?Collection;
}
