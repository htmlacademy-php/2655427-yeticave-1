<?php

declare(strict_types=1);

const VALIDATOR_SEPARATOR = ':';
const VALIDATOR_PARAMS_SEPARATOR = '&';
const VALIDATOR_PARAM_VALUE_SEPARATOR = '=';

const ADD_LOT_FORM_KEY = 'add-lot';
const SIGN_UP_FORM_KEY = 'sign-up';


const VALIDATION_RULES = [
    ADD_LOT_FORM_KEY  => [
        'category'    => [
            'required',
            'category'
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
    ],
    SIGN_UP_FORM_KEY  => [
        'email'       => [
            'required',
            'string:min=4&max=128',
            'email'
        ],
        'name'        => [
            'required',
            'string:min=4&max=128',
            'name:filter'
        ],
        'password'    => [
            'required',
            'string:min=8&max=255',
            'password'
        ],
        'message'     => [
            'required',
            'string:min=5'
        ]
    ]
];
