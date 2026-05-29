<?php

declare(strict_types=1);

const ALLOWED_IMAGE_MIME_TYPES = [
    'image/png',
    'image/jpeg',
];

const ALLOWED_IMAGE_EXTENSIONS = [
    'jpg',
    'jpeg',
    'png',
];

const VALIDATOR_SEPARATOR = ':';
const VALIDATOR_PARAMS_SEPARATOR = '&';
const VALIDATOR_PARAM_VALUE_SEPARATOR = '=';

const ADD_LOT_FORM_KEY = 'add-lot';

const VALIDATION_RULES = [
    ADD_LOT_FORM_KEY  => [
        'category'    => [
            'required'
        ],
        'lot-name'    => [
            'required',
            'string:min=5&max=255'
        ],
        'message'     => [
            'required',
            'string:min=5'
        ],
        'lot-rate'    => [
            'required',
            'int:min=1'
        ],
        'lot-step'    => [
            'required',
            'int:min=1'
        ],
        'lot-date'    => [
            'required',
            'date:format=Y-m-d&gt=today'
        ]
    ]
];