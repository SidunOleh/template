<?php // default exception handler

use App\Components\Response;

set_exception_handler(function ($e) {

    if (ENV == 'local') {
        $response = Response::view('error', compact('e'));

        echo $response;
    }

    if (ENV == 'prod') {
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';

        header('Location:' . $redirect);
    }
    
});
