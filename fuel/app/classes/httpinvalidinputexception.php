<?php

class HttpInvalidInputException extends HttpException
{
    public function response()
    {
        $response = \Fuel\Core\Request::forge('error/invalid')->execute(array($this->getMessage())->response());
        return $response;
    }
}


