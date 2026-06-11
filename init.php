<?php

declare(strict_types=1);
date_default_timezone_set('UTC');

require_once 'config/constant.php';

require_once 'enum/HttpMethodEnum.php';
require_once 'enum/HttpStatusCodeEnum.php';

require_once 'functions/helpers.php';
require_once 'functions/functions.php';

require_once 'functions/form/prepare.php';
require_once 'functions/form/upload.php';

require_once 'functions/database/core.php';
require_once 'functions/database/query/lot.php';
require_once 'functions/database/query/bid.php';
require_once 'functions/database/query/user.php';
require_once 'functions/database/query/category.php';

require_once 'validation/const.php';
require_once 'validation/rules.php';
require_once 'validation/index.php';
require_once 'validation/validators.php';

$con = connectToMySQL();

$categories = getAllCategories($con);

session_start();

$auth_user = [
    'name' => $_SESSION[USER_SESSION_KEY]['name'] ?? '',
    'id'   => $_SESSION[USER_SESSION_KEY]['id'] ?? null,
];
