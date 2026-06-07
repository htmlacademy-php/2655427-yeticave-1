<?php

declare(strict_types=1);

require_once 'config/constant.php';

unset($_SESSION[USER_SESSION_KEY]);
header("Location: /index.php");
