<?php 
    $index = function(){
        readfile("./view/index/index.html");
        echo "Without args";
    };

    $indexGET = function($arg1){
        readfile("./view/index/index.html");
        echo "Arg1 = ".$arg1;
    };

    $indexPOST = function ($arg1, $arg2){
        readfile("./view/index/index.html");
        echo "Arg1 = ".$arg1." Arg2 = ".$arg2;
    };
?>