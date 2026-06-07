<?php

declare(strict_types=1);

require_once 'init.php';

session_start();

unset($_SESSION[USER_SESSION_KEY]);
header("Location: /index.php");
