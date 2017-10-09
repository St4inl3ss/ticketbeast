<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 17/09/17
 * Time: 5:10 PM
 */

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestResponse;

/**
 * Class CustomTestCase
 *
 * Test class including custom helper methods
 *
 * @package Tests
 */
class CustomTestCase extends TestCase
{

    /**
     * @param TestResponse $response
     * @throws \Exception
     */
    protected function checkResponse(TestResponse $response)
    {
        if ($response->isClientError() || $response->isServerError()) {
            throw $response->exception;
        }
    }

    /**
     * disable Exception Handler for better debugging of tests
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler
            {
                public function __construct()
                {
                }

                public function report(Exception $exception)
                {
                }

                public function render($request, Exception $exception)
                {
                    dd((string)$exception);
                }
            }
        );
    }
}