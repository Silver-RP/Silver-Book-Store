<?php
    require_once('config/config.php');
    class HomeController{

        public function view(){
            require_once(BASE_PATH .'app/view/layout/BannerCarousel.php');
            require_once(BASE_PATH .'app/view/layout/MainNav.php');
            require_once(BASE_PATH .'app/view/layout/Home.php');
            // require_once('__DIR__' . '/../../view/layout/Footer.php');
        }
    }
?>