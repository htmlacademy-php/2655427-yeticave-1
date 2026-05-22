<?php

declare(strict_types=1);

require_once 'util/constant.php';

require_once 'enum/HttpMethodEnum.php';
require_once 'enum/HttpStatusCodeEnum.php';

require_once 'functions/database-connect.php';
require_once 'functions/database-core.php';
require_once 'functions/database.php';
require_once 'functions/functions.php';
require_once 'functions/helpers.php';
require_once 'functions/validate/validate-form-data.php';
require_once 'functions/validate/validate-form-image.php';

$con = connectToMySQL();

$categories = getAllCategories($con);
$lots = getNewLots($con);

$user = [
    'is_auth'   => rand(0, 1),
    'user_name' => 'Виктория'
];
