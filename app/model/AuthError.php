<?php

namespace app\app\model;
use Throwable;

class AuthError extends \Exception
{
    protected $code = 401;
    protected $message = 'Auth-Error : ';

    /**
     * @param string $message
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->message = $this->message.$message;
        parent::__construct($this->message, $code, $previous);
    }


}