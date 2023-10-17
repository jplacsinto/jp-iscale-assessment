<?php
// Include the autoloader to load classes automatically.
require_once 'vendor/autoload.php';

// Load database configuration from the config file.
$config = require_once 'config/dbconfig.php';

// Import necessary classes and namespaces.
use App\Database\Database;
use App\Models\News;
use App\Models\Comment;
use App\Repositories\NewsRepository;
use App\Repositories\CommentRepository;

// Create a new Database instance using the provided configuration.
$database = new Database($config);


// Initialize the NewsRepository with the Database and News model.
$newsModel = new News();
$newsRepository = new NewsRepository($database, $newsModel);

// Initialize the CommentRepository with the Database and Comment model.
$commentModel = new Comment();
$commentRepository = new CommentRepository($database, $commentModel);


$response = array();// Create an array to store the response data.

// Retrieve all news items along with their associated comments
// then loop through each news item and convert it to an array.
$news = $newsRepository->findAllWithComments();
foreach ($news->getAll() as $n) {
    $response[] = $n->toArray();
}

// Set the HTTP response headers for JSON data and output it to the client as json.
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, true);




/**
 * Create News
 */
// try{
//     $news = $newsRepository->create([
//         'title' => 'Gojo has been sealed!',
//         'body' => 'Oh no! The strongest sorcerer has been sealed!',
//         'created_at' => date('Y-m-d H:i:s')
//     ]);
//     $response = ['message' => 'Success'];
// } catch (Exception $e) {
//     $response = ['message' => $e->getMessage()];
// }

/**
 * Create Comment
 */
// try{
//     $news = $commentRepository->create([
//         'news_id' => 1,
//         'body' => 'Oh no! The strongest sorcerer has been sealed!',
//         'created_at' => date('Y-m-d H:i:s')
//     ]);
//     $response = ['message' => 'Success'];
// } catch (Exception $e) {
//     $response = ['message' => $e->getMessage()];
// }

/**
 * Get news by id
 */
// $news = $newsRepository->findByIdWithComments(2);
// $response = $news->toArray();
//var_dump($response);


/**
 * Update news by id
 */
// try{
//     $newsId = 12;
//     $news = $newsRepository->update($newsId, [
//         'title' => 'Gojo has been sealed!',
//         'body' => 'Deym! The strongest sorcerer has been sealed!',
//         'created_at' => date('Y-m-d H:i:s')
//     ]);
//     $response = ['message' => 'Success'];
// } catch (Exception $e) {
//     $response = ['message' => $e->getMessage()];
// }

/**
 * Delete news by id
 */
// try{
//     $newsId = 13;
//     $news = $newsRepository->delete($newsId);
//     $response = ['message' => $news > 0 ? 'Success' : 'Failed'];
// } catch (Exception $e) {
//     $response = ['message' => $e->getMessage()];
// }