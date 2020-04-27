<?php

return [
    ['GET', '/users/:id', 'UserController@show', ['auth']],
    ['PUT', '/users/:id', 'UserController@update', ['auth']],

    // Todo Use this route for testing purpose only
    ['GET', '/login', 'HelpController@login'],
    ['GET', '/logout', 'HelpController@logout'],
    ['GET', '/update-user', 'HelpController@testUpdateUser'],
];
