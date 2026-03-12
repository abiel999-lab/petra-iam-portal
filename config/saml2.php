<?php

return [
    'useRoutes' => true,
    'routesPrefix' => 'saml2',
    'routesMiddleware' => ['web'],
    'retrieveParametersFromServer' => false,

    'loginRoute' => '/',
    'logoutRoute' => '/',
    'errorRoute' => null,

    'strict' => true,
    'debug' => env('APP_DEBUG', false),
];
