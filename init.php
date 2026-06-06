<?php

declare(strict_types=1);

require_once 'util/constant.php';

require_once 'enum/HttpMethodEnum.php';
require_once 'enum/HttpStatusCodeEnum.php';

require_once 'functions/helpers.php';
require_once 'functions/functions.php';
require_once 'functions/database/core.php';
require_once 'functions/database/query.php';
require_once 'functions/form.php';

require_once 'validation/const.php';
require_once 'validation/rules.php';
require_once 'validation/index.php';
require_once 'validation/validators.php';

$con = connectToMySQL();

$categories = getAllCategories($con);
$users = getAllUsers($con);

session_start();

$is_auth = isset($_SESSION['user']);

$user_name = $_SESSION['user']['name'] ?? '';
$user_id = $_SESSION['user']['id'] ?? null;
