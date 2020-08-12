<?php
    require "./controller.php"; //Api controller
    require "./handlers.php"; //Functions to handle requests
    require "./model/db.php"; //Data base handler

    $app = new app();

    $app->get("/", $index);
    $app->get("/index/{arg1}", $indexGET);
    $app->post("/index/{arg1}/{arg2}", $indexPOST);
    
    $app->ready();
?>