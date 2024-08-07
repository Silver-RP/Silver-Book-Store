<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Silver-Book Store</title>

  <!-- <link rel="stylesheet" href="../public/css/addmin/style.css"> (use for admin/index.php)  -->
  <link rel="stylesheet" href="/SilverBook/public/css/addmin/style.css"> 
  <link rel="stylesheet" href="/SilverBook/public/css/addmin/addUser.css"> 
  <link rel="stylesheet" href="/SilverBook/public/css/addmin/allComments.css"> 
  <link rel="stylesheet" href="/SilverBook/public/css/addmin/orderDetail.css"> 

  <!-- <link rel="stylesheet" type="text/css" href="../../../public/css/addmin/style.css"> (USE for view/books/Allbooks.php) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>

  </style>

</head>

<body>
  <header id="header" class="header fixed-top">
    <div class="container-fluid bg-warning ">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand d-flex align-items-center" href="?act=home">
          <span class="ml-2 d-none d-lg-block text-warning fs-3 fw-bolder shadow-sm bg-body-tertiary rounded p-1">
            SilverBook Admin
          </span>
        </a>

        <form action="" class="form-inline my-2 my-lg-0 col-md-7 focus ps-5">
          <div class="input-group col-md-8 container dropdown">
            <a class="btn btn-secondary dropdown-toggle bt" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ALL
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item dr" href="?act=index">Books</a></li>
              <li><a class="dropdown-item dr" href="#">Categories</a></li>
              <li><a class="dropdown-item dr" href="#">Usesr</a></li>
              <li><a class="dropdown-item dr" href="#">Orders</a></li>
              <li><a class="dropdown-item dr" href="#">Reviews</a></li>
              <li><a class="dropdown-item dr" href="#">Inventory</a></li>
              <li><a class="dropdown-item dr" href="#">Sales Reports</a></li>
              <li><a class="dropdown-item dr" href="#">Promotions and Discounts</a></li>
            </ul>
            <div class="col-auto">
              <input type="text" id="inputPassword6" class="form-control fr" aria-describedby="passwordHelpInline" placeholder="Search by Title, Author or Keyword">
            </div>
            <button type="button " class="btn btn-primary bts"><i class="fa-solid fa-magnifying-glass "></i></button>
          </div>
        </form>

        <div class=" navbar-collapse justify-content-end me-3 col-md-3 " id="navbarNavDropdown">
          <ul class="navbar-nav me-5">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i>
                <span class="badge bg-primary badge-number">4</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end notifications d-ms" aria-labelledby="navbarDropdownMenuLink">
                <h6 class="dropdown-header">You have 4 new notifications</h6>
                <a class="dropdown-item ms-item" href="#">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h6>Lorem Ipsum</h6>
                    <p>Quae dolorem earum veritatis odi sara</p>
                    <p>30 min. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item ms-item" href="#">
                  <i class="bi bi-x-circle text-danger"></i>
                  <div>
                    <h6>Atque rerum nesciunt</h6>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>1 hr. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item ms-item" href="#">
                  <i class="bi bi-check-circle text-success"></i>
                  <div>
                    <h6>Sit rerum fuga</h6>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>2 hrs. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item ms-item" href="#">
                  <i class="bi bi-info-circle text-primary"></i>
                  <div>
                    <h6>Dicta reprehenderit</h6>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>4 hrs. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item dropdown-footer" href="#">Show all notifications</a>
              </div>
            </li>
            <!-- messagesDropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-chat-left-text"></i>
                <span class="badge bg-success badge-number">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end d-ms" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">You have 3 new messages</h6>
                <a class="dropdown-item message-item ms-item" href="#">
                  <img src="" alt="" class="rounded-circle">
                  <div>
                    <h6>Maria Hudson</h6>
                    <p>Velit asperiores et ducimus soluta
                      repudiandae labore officia est ut...</p>
                    <p>4 hrs. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item message-item ms-item" href="#">
                  <img src="" alt="" class="rounded-circle">
                  <div>
                    <h6>Anna Nelson</h6>
                    <p>Velit asperiores et ducimus soluta
                      repudiandae labore officia est ut...</p>
                    <p>6 hrs. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item message-item ms-item" href="#">
                  <img src="" alt="" class="rounded-circle">
                  <div>
                    <h6>David Muldon</h6>
                    <p>Velit asperiores et ducimus soluta
                      repudiandae labore officia est ut...</p>
                    <p>8 hrs. ago</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item dropdown-footer" href="#">Show all messages</a>
              </div>
            <!-- Account Management -->
            </li>
            <li class="nav-item dropdown me-2">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="ms-2 fw-semibold">
                  <?php
                    echo (isset($_SESSION['user'])) ? $_SESSION['user']['user_name'] : 'Kensilver Book';
                   ?>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-end m-2 ps-2" aria-labelledby="profileDropdown">
                <h6 class="dropdown-header">Silver Ken</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="bi bi-gear"></i>
                  <span>Account Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="bi bi-question-circle"></i>
                  <span>Need Help?</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/SilverBook/admin/view/layout/login.php">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </div>
            </li>

          </ul>
        </div>
      </nav>
    </div>
  </header>
  <div class="container-fluid ">
    <div class="row">
      <nav class="col-md-3 col-lg-2 d-md-block bg-warning sidebar nav-lef" style="min-height: 650px !important;">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item mt-2">
              <a class="nav-link active text-black" aria-current="page" href="?act=home">
                <i class="fa-solid fa-bars-progress"></i>
                Dashboard Management
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active text-black dropdown-toggle" href="#" id="productsDropdown" role="button">
                <i class="fa-solid fa-circle"></i>
                Books
              </a>
              <ul class="dropdown-menu bg-warning ps-4 dr" aria-labelledby="productsDropdown">
                <li><a class="dropdown-item dr-a" href="?act=books&action=index">All Books</a></li>
                <li><a class="dropdown-item dr-a" href="?act=categories&action=index">Categories</a></li>
                <li><a class="dropdown-item dr-a" href="?act=authors&action=index">Authors</a></li>
                <li><a class="dropdown-item dr-a" href="?act=publishers&action=index">Publisheres</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active text-black dropdown-toggle" href="#" id="usersDropdown" role="button">
                <i class="fa-solid fa-user"></i>
                Users
              </a>
              <ul class="dropdown-menu bg-warning ps-4 dr" aria-labelledby="usersDropdown">
                <li><a class="dropdown-item dr-a" href="?act=user&action=index">All Users</a></li>
                <li><a class="dropdown-item dr-a" href="?act=user&action=add">Add User</a></li>
                <li><a class="dropdown-item dr-a" href="#">Active Users</a></li>
                <li><a class="dropdown-item dr-a" href="#">Inactive Users</a></li>
                <li><a class="dropdown-item dr-a" href="#">Manage Roles</a></li>
                <li><a class="dropdown-item dr-a" href="#">User of Reviews</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active text-black dropdown-toggle" href="#" id="orderDropdown" role="button">
                <i class="fa-solid fa-inbox"></i>
                Orders
              </a>
              <ul class="dropdown-menu bg-warning ps-4 dr" aria-labelledby="orderDropdown">
                <li><a class="dropdown-item dr-a" href="?act=orders&action=index">All Orders</a></li>
                <li><a class="dropdown-item dr-a" href="#">Pending Orders</a></li>
                <li><a class="dropdown-item dr-a" href="#">Processing Orders</a></li>
                <li><a class="dropdown-item dr-a" href="#">Completed Orders</a></li>
                <li><a class="dropdown-item dr-a" href="#">Cancelled Orders</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-black dropdown-toggle" href="#" id="commentDropdown" role="button">
              <i class="fa-solid fa-comments"></i>
                Reviews
              </a>
              <ul class="dropdown-menu bg-warning ps-4 dr" aria-labelledby="commentDropdown">
                <li><a class="dropdown-item dr-a" href="?act=reviews&action=index">All Comments</a></li>
                <li><a class="dropdown-item dr-a" href="?act=reviews&action=allhide">Hide Comments</a></li>
                <li><a class="dropdown-item dr-a" href="#">Edit Comments</a></li>
                <li><a class="dropdown-item dr-a" href="#">Delete Comments</a></li>
                <li><a class="dropdown-item dr-a" href="#">Reply Management</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-black" href="#">
                <i class="fa-solid fa-flag"></i>
                Reports
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-black" href="#">
              <i class="fa-solid fa-border-top-left"></i>
                Integrations
              </a>
            </li>
          </ul>
        </div>
      </nav>