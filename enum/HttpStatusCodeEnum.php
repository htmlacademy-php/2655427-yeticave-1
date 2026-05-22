<?php

declare(strict_types=1);

namespace enum;

enum HttpStatusCodeEnum: int
{
    case HttpOk = 200;
    case HttpNotFound = 404;
}
