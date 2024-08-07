<?php
class SearchController {
    private $searchModel;

    public function __construct() {
        $this->searchModel = new SearchModel();
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $keyword = $_GET['keyword'] ?? null;

            if ($keyword) {
                $results = $this->searchModel->search($keyword);
                
                require 'app/view/common/SearchResults.php';
            } else {
                http_response_code(400);
                echo '
                <div class="container py-5 my-5"> 
                    <h3>Search Results for "<?php echo htmlspecialchars($keyword); ?>"</h3>
                    <p>No keyword provided</p>
                </div>';
            }
        } else {
            http_response_code(405);
            echo 'Invalid request method';
        }
    }
}


?>
