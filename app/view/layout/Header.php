<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silver-Book</title>

    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/app-css/Books.css">
    <link rel="stylesheet" href="public/css/app-css/BookDetail.css">
    <link rel="stylesheet" href="public/css/app-css/Signup.css">
    <link rel="stylesheet" href="public/css/app-css/BooksInCart.css">
    <link rel="stylesheet" href="public/css/app-css/UserProfile.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
</head>

<body>
    <div class="success-message" id="success-message" style="display: none;"></div>
    <!--1. Header  -->
    <!-- 1.1 -->
    <section class="container container-f">
        <div class="row">

            <div class="col-md-12 d-flex justify-content-between">
                <!-- 1.1 Left -->
                <ul class="nav justify-content-start nav-u">
                    <li class="nav-item">
                        <a href="" class="nav-link nav-l">
                            <span class="">
                                <i class="fa-solid fa-location-dot"></i> STORE AND EVENT
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link  nav-l">
                            <span class="">BLOG AND PODCAST</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link  nav-l">
                            <span class="">MEMBERSHIP</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link  nav-l">
                            <span class="">COUPONS AND DEALS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link  nav-l">
                            <span class="">BESTSALLERS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link  nav-l">
                            <span class="">GIFT CARDS</span>
                        </a>
                    </li>
                </ul>
                <!-- 1.2 Right -->
                <ul class="nav justify-content-end nav-uu">
                    <li class="nav-item">
                        <div class="dropdown">
                            <?php if (isset($_SESSION['user'])) : ?>
                                <a class="btn nav-link  nav-l dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class=""> <i class="fa-solid fa-user"></i> Hello <?php echo $_SESSION['user']['user_name']; ?> </span>
                                </a>
                            <?php else : ?>
                                <a class="btn nav-link  nav-l dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class=""> <i class="fa-solid fa-user"></i> MY ACCOUNT </span>
                                </a>
                            <?php endif; ?>

                            <ul class="dropdown-menu align-center text-center ul-myAcount">
                                <?php if (isset($_SESSION['user'])) : ?>
                                    <li><a class="dropdown-item btn-signin " href="?route=user&subroute=profile">Profile</a></li>
                                    <li><a class="dropdown-item btn-signup btn-account" href="?route=user&subroute=signout">
                                            Sign Out</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item btn-signin " href="?route=user&subroute=signin">Sign In </a></li>
                                    <li><a class="dropdown-item btn-signup btn-account" href="?route=user&subroute=viewsignup">
                                            Create an Account
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <hr style="margin: 0px !important;">
                                <li><a class="dropdown-item btn-account" href="#">Manage Account</a></li>
                                <li><a class="dropdown-item btn-account" href="#">Orders</a></li>
                                <li><a class="dropdown-item btn-account" href="#">Help?</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="?route=wish&subroute=view" class="nav-link  nav-l">
                            <span class=""> <i class="fa-solid fa-heart"></i> WISHLIST</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="px-5 mb-3 ms-5 sticky-form-search">
        <!-- 1.2 Form Search -->
        <div class="col-md-12 s-logo-bar p-2 d-flex form-search">
            <a href="?route=home" class="logo-img p-2">
                <img src="public/images/common/logo-img1.png" alt="Logo" width="200px" height="50px">
            </a>
            <form method="get" action="index.php" class="form-inline my-2 my-lg-0 col-md-8 focus p-2">
                <div class="input-group col-md-12 focus1 container dropdown">
                    <a id="category-button" class="btn btn-secondary dropdown-toggle bt" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-category="all">
                        ALL
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-category="books">Books</a></li>
                        <li><a class="dropdown-item" href="#" data-category="category">Category</a></li>
                        <li><a class="dropdown-item" href="#" data-category="audio-books">Audio Books</a></li>
                        <li><a class="dropdown-item" href="#" data-category="ebooks">EBooks</a></li>
                        <li><a class="dropdown-item" href="#" data-category="text-books">Text Books</a></li>
                        <li><a class="dropdown-item" href="#" data-category="kids">Kids</a></li>
                        <li><a class="dropdown-item" href="#" data-category="teens">Teens</a></li>
                        <li><a class="dropdown-item" href="#" data-category="trend-books">Trend Books</a></li>
                        <li><a class="dropdown-item" href="#" data-category="sale-books">Sale Books</a></li>
                    </ul>
                    <div class="col-auto">
                        <input type="text" id="search-input" name="keyword" class="form-control fr" placeholder="Search by Title, Author or Keyword">
                        <div id="search-results"></div>

                    </div>
                    <button type="button" id="search-button" class="btn btn-primary bts">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
            <ul class="nav justify-content-end col-md-2 py-2 px-5">
                <li class="nav-item">
                    <a href="?route=cart&subroute=view" class="nav-link nav-l1">
                        <span class="cart-icon">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                            <span class="cart-count">
                                <?php echo isset($_SESSION['cart']) ? $_SESSION['cart'] : 0; ?>
                            </span>
                            CART
                        </span>
                    </a>
                </li>
            </ul>

        </div>

    </section>
    <section class="container">
        <!-- 1.3 Nav bar -->
        <div class="collapse navbar-collapse d-flex">
            <div class="col-md-12">
                <ul class="nav ">
                    <li class="nav-item dropdown"><a href="?route=books&subroute=show" class="nav-link nav-l3">Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Fiction</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Nonfiction</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">EBooks</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Teen Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Kids Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Cook Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Music Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">Movie Books</a></li>
                    <li class="nav-item dropdown"><a href="" class="nav-link nav-l3">IT Books</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section></section>
    <!--2. Banner 1-->
    <section class="container-fluid">
        <div class="">
            <img src="public/images/common/Approved2.png" alt="Our banner" width="100%" height="200px">
        </div>
    </section>
    <!--3. Carousel -->