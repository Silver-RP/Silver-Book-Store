<?php
ob_start();
session_start();
session_abort();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once('config/database.php');
require_once('admin/model/BookModel.php');
require_once('admin/model/CategoryModel.php');
require_once('admin/model/AuthorModel.php');
require_once('admin/model/PublisherModel.php');
require_once('admin/model/UserModel.php');
require_once('admin/model/SearchModel.php');

require_once('app/model/WishListModel.php');
require_once('app/model/CartModel.php');
require_once('app/model/CartBookModel.php');

require_once('app/controller/HomeController.php');
require_once('app/view/layout/Header.php');

// var_dump($_SESSION['user']);
// var_dump($_SESSION['cart']);

if (isset($_GET['route'])) {
    $route = $_GET['route'];

    switch ($route) {
        case 'home':
            $home = new HomeController();
            $home->view();
            break;
        case 'books':
            require_once('app/controller/BookController.php');
            $book = new BookController();
            if (isset($_GET['subroute'])) {
                $subroute = $_GET['subroute'];
                switch ($subroute) {
                    case 'show':   $book->showAllBooks(); break;
                    case 'detail': $book->detailBook();   break;
                    case 'review': $book->reviewBook(); break;
                    case 'reviews': 
                        echo '<script>console.log("reviews")</script>';
                        $book->getBookReviews(); break;
                    default: 
                        $book->showAllBooks();       break;
                }
            }
            break;
        case 'user':
            require_once('app/controller/UserController.php');
            $user = new UserController();

            if (isset($_GET['subroute'])) {
                $subroute = $_GET['subroute'];
                switch ($subroute) {
                    case 'signin': $user->signin(); 
                        break;
                    case 'viewsignup': $user->viewSignup(); 
                        break;
                    case 'signup': $user->signup(); 
                        break;
                    case 'signout': $user->signout(); 
                        break;
                    case 'profile': $user->profile(); 
                        break;
                    case 'viewEditprofile': $user->viewEditProfile(); 
                        break;
                    case 'edit': $user->editProfile(); 
                        break;
                    case 'viewChangePass': $user->viewChangePass(); 
                        break;
                    case 'changepass': $user->changePass(); 
                        break;
                    case 'forgotPassword': $user->forgotPassword();
                        break;
                    case 'checkEmailPhone': $user->checkEmailPhone();
                        break;
                        // case 'checkout':
                        //     $user = new UserController();
                        //     $user->checkout();
                        //     break;
                        // case 'order':
                        //     $user = new UserController();
                        //     $user->order();
                        //     break;
                        // case 'orderdetail':
                        //     $user = new UserController();
                        //     $user->orderDetail();
                        //     break;
                        // case 'orderhistory':
                        //     $user = new UserController();
                        //     $user->orderHistory();
                        //     break;
                        // case 'orderhistorydetail':
                        //     $user = new UserController();
                        //     $user->orderHistoryDetail();
                        //     break;
                    default:
                        $home = new HomeController();
                        $home->view();
                        break;
                }
            }
            break;
        case 'wish':
            require_once('app/controller/WishListController.php');
            if (isset($_GET['subroute'])) {
                $subroute = $_GET['subroute'];
                switch ($subroute) {
                    case 'add':
                        $wish = new WishListController();
                        $wish->addWish();
                        error_log('Received POST data: ' . print_r($_POST, true));
                        break;
                    case 'view':
                        $wish = new WishListController();
                        $wish->view();
                        break;
                    case 'remove':
                        $wish = new WishListController();
                        $wish->removeWish();
                        break;
                    case 'removepage':
                        $wish = new WishListController();
                        $wish->removeWishFromWishPage();
                        break;
                    default:
                        $home = new HomeController();
                        $home->view();
                        break;
                }
            }
            break;
        case 'cart':
            require_once('app/controller/CartController.php');
            if (isset($_GET['subroute'])) {
                $subroute = $_GET['subroute'];
                switch ($subroute) {
                    case 'add':
                        $cart = new CartController();
                        $cart->addCart();
                        break;
                    case 'view':
                        $cart = new CartController();
                        $cart->viewBooksInCart();
                        break;
                    case'update':
                        $cart = new CartController();
                        $cart->updateQuantityBookInCart();
                        break;
                    case 'remove':
                        $cart = new CartController();
                        $cart->removeBookFromCart();
                        break;
                    // case 'checkout':
                    //     $cart = new CartController();
                    //     $cart->checkout();
                    //     break;
                    default:
                        $home = new HomeController();
                        $home->view();
                        break;
                }
            }
            break;
        case 'search':
            require_once('app/controller/SearchController.php');
            $search = new SearchController();
            if (isset($_GET['subroute'])) {
                $subroute = $_GET['subroute'];
                switch ($subroute) {
                    case 'search':
                        echo 'Debug: Reached search case'; 

                        $search->search();
                        break;
                        default:
                        echo '<p>Invalid route</p>';
                        break;
                }
            }
            break;
        default:
            $home = new HomeController();
            $home->view();
            break;
    }
} else {
    $home = new HomeController();
    $home->view();
}



require_once('app/view/layout/Footer.php');
