<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 17/09/17
 * Time: 5:10 PM
 */

namespace Tests;
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
}