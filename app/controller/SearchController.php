<?php
class SearchController {
    private $searchModel;

    public function __construct() {
        $this->searchModel = new SearchModel();
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['route']) && $_GET['route'] === 'search' && isset($_GET['subroute']) && $_GET['subroute'] === 'search') {
                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : 'all';
                $books = $this->searchModel->search($keyword, $category);
                header('Content-Type: application/json');

                echo json_encode(['books' => $books, 'keyword' => $keyword, 'category' => $category, 'count' => count($books), 'error' => 'qqqqqqqqqq']);
                echo "<pre>";
                print_r($books);
                echo "</pre>";

                // exit();
            // } else {
            //     http_response_code(404);
            //     echo json_encode(['error' => 'Not Found']);
            //     exit();
            }
        // } else {
        //     http_response_code(405);
        //     echo json_encode(['error' => 'Method Not Allowed']);
        //     exit();
        }
    }
    
   
    
}
?>
