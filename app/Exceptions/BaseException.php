<?php
/**
 * Created by PhpStorm.
 * User: Suja.Varghese
 * Date: 18/05/2017
 * Time: 11:11 PM
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class BaseException extends ExceptionHandler
{

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */

}

class ConfigException extends BaseException
{
}

class RuntimeException extends \Exception
{
}

class BadRequestHttpException extends ExceptionHandler
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, array(), $code);
    }
}