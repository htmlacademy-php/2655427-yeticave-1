<?php

session_start();

unset($_SESSION[USER_SESSION_KEY]);
header("Location: /index.php");
