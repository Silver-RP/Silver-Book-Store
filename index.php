<?php
session_start();
session_abort();

require_once('config/database.php');
require_once('app/controller/HomeController.php');


require_once('app/view/layout/Header.php');

    if(isset($_GET['$page'])){
        $page = $_GET['$page'];

        switch($page){
            case 'home':
                $home = new HomeController();
                $home->view();
                break;
            
        }
    }else{
        $home = new HomeController();
        $home->view();
    }



require_once('app/view/layout/Footer.php');
?>