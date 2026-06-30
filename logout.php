<?php

    session_destroy();
    session_unset();
    unset($_COOKIE);
    

    header("Location: login.php");
    exit();
?>