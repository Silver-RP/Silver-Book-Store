<?php
require_once('../config/database.php');

require_once('view/layout/header.php');



if (!empty($_GET['act'])) {
    $act = $_GET['act'];

    switch ($act) {
        case 'home':
            require_once('view/layout/home.php');
            break;

        case 'books':
            require_once('controller/BookController.php');
            $bookController = new BookController();
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';

            switch ($action) {
                case 'index':
                    $bookController->index();
                    break;
                case 'detail':
                    $bookController->viewBookDetail();
                    break;
                case 'add':
                    $bookController->add();
                    break;
                case 'store':
                    $bookController->store();
                    break;
                case 'edit':
                    $bookController->edit();
                    break;
                case 'update':
                    $bookController->update();
                    break;
                case 'delete':
                    $bookController->delete();
                    break;
                case 'confirmDelete':
                    $bookController->confirmDelete();
                    break;
                default:
                    $bookController->index();
                    break;
            }
            break;

        case 'categories':
            require_once('controller/CategoryController.php');
            $cateController = new CategoryController();
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';

            switch ($action) {
                case 'index':
                    $cateController->index();
                    break;
                case 'add':
                    $cateController->add();
                    break;
                case 'store':
                    $cateController->store();
                    break;
                case 'edit':
                    $cateController->edit();
                    break;
                case 'update':
                    $cateController->update();
                    break;
                case 'delete':
                    $cateController->delete();
                    break;
                case 'updateBooksAndDelete':
                    $cateController->updateBooksAndDelete();
                    break;
                case 'confirmDelete':
                    $cateController->confirmDelete();
                    break;
                default:
                    $cateController->index();
                    break;
            }
            
            break;
        
        case 'authors':
            require_once('controller/AuthorController.php');
            $authorController = new AuthorController();
            require_once('controller/PublisherController.php');
            $publisherController = new PublisherController();
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';

            switch ($action) {
                case 'index':
                    $authorController->index();
                    break;
                case 'add':
                    $authorController->add();
                    break;
                case 'store':
                    $authorController->store();
                    break;
                case 'edit':
                    $authorController->edit();
                    break;
                case 'update':
                    $authorController->update();
                    break;
                case 'delete':
                    $authorController->delete();
                    break;
                case 'confirmDelete':
                    $authorController->confirmDelete();
                    break;
                default:
                    $authorController->index();
                    break;
            }
            break;

        case 'publishers':
            require_once('controller/PublisherController.php');
            $publisherController = new PublisherController();
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';

            switch ($action) {
                case 'index':
                    $publisherController->index();
                    break;
                case 'add':
                    $publisherController->add();
                    break;
                case 'store':
                    $publisherController->store();
                    break;
                case 'edit':
                    $publisherController->edit();
                    break;
                case 'update':
                    $publisherController->update();
                    break;
                case 'delete':
                    $publisherController->delete();
                    break;
                case 'confirmDelete':
                    $publisherController->confirmDelete();
                    break;
                default:
                    $publisherController->index();
                    break;
            }
            break;

        default:
            require_once('view/layout/home.php');
            break;
    }
} else {
    require_once('view/layout/home.php');
}



require_once('view/layout/footer.php');
?>
