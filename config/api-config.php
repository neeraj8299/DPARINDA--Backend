<?php
return [
    'STATUS_CODE' => [
        'SUCCESS' => 200,
        'NOT_FOUND' => 404,
        'UNAUTHORIZED' => 401,
        'SERVER_ERROR' => 500,
        'HTTP_METHOD_NOT_ALLOWED_CODE' => 405,
        'UNPROCESSABLE_ENTITY' => 422,
        'NOT_ACCEPTABLE_CODE' => 406,
        'SERVICE_UNAVAILABLE' => 503,
        'BAD_REQUEST' => 400,
    ],
    'DEFAULT_ERROR' => [
        'MESSAGE' => 'This is the default error message',
    ],
    'DEFAULT_SUCCESS' => [
        'MESSAGE' => 'This is the default success message',
    ],
    'MESSAGES' => [
        'SUCCESSFULLY_REGISTERED_USER' => 'User Registered Succesfully Kindly Login',
        'LOGGED_IN_SUCCESSFULL' => 'Logged In Successfully',
        'RESOURCE_NOT_FOUND' => 'RESOURCE_NOT_FOUND',
        'SUCCESS_REQUEST' => 'Success',
        'NOT_FOUND_REQUEST' => 'NOT_FOUND',
        'UNAUTHORIZED_REUQUEST' => 'UNAUTHORIZED',
        'SERVER_ERROR_REUQUEST' => 'INTERNAL_SERVER_ERROR',
        'HTTP_METHOD_NOT_ALLOWED_MESSAGE' => 'HTTP_METHOD_NOT_ALLOWED',
        'UNPROCESSABLE_ENTITY' => 'REQUEST_ENTITY_IS_INCORRECT',
        'NOT_ACCEPTABLE_MESSAGE' => 'NOT_ACCEPTABLE',
        'SUCCESS' => 'Success',
        'AUTHORIZATION_SUCCESS' => 'Authentication Successful.',
        'BAD_REQUEST' => 'INVALID_REQUEST',
        'INVALID_CREDENTIALS' => 'INVALID_CREDENTIALS',
    ],
    'NON_EDITABLE_ROLE_SLUG' => [
        'super-admin'
    ]
];
