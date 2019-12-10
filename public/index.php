<?php
    $rootFolder = "/var/www/api";
    include_once( $rootFolder . "/vendor/autoload.php" );

    $app = new \Slim\App;
    
    // routes =======================
    include_once( $rootFolder . "/routes/hello-world.php" );
    include_once( $rootFolder . "/routes/user.php" );
    // routes =======================
    
    $app->run();