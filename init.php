<?php

declare(strict_types=1);

require_once 'util/constant.php';

require_once 'enum/HttpMethodEnum.php';
require_once 'enum/HttpStatusCodeEnum.php';

require_once 'functions/database/core.php';
require_once 'functions/database/query.php';
require_once 'functions/functions.php';
require_once 'functions/helpers.php';
require_once 'validate/const-rulse.php';
require_once 'validate/form-data.php';
require_once 'validate/required-fields.php';

$con = connectToMySQL();

$categories = getAllCategories($con);
$lots = getNewLots($con);

$user = [
    'is_auth'   => rand(0, 1),
    'user_name' => 'Виктория'
];
