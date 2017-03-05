<?php

    $string  = "093罪恶的牙医";
    if(preg_match("/[']/", $string))
    {
        print_r("ok");
    }
?>