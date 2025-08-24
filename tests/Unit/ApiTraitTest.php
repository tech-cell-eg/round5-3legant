<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponseTrait;

class ApiTraitTest extends TestCase {
    /**
     * A basic unit test example.
     */
    use APIResponseTrait;
    public function test_return_success_response_with_default_values(): void {
        $response = $this->successResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([
            'success' => true,
            'message' => 'Success'
        ], $response->getData(true));
    }
    public function test_return_success_response_with_custom_values(): void {
        $data = ['id' => 1, 'username' => 'ahmed', 'email' => 'ahmed'];
        $response = $this->successResponse($data, 'User Created', 201);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals([
            'success' => true,
            'message' => 'User Created',
            'data' => $data
        ], $response->getData(true));
    }
    public function test_return_error_response_with_default_values(): void {
        $response = $this->errorResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals([
            'success' => false,
            'message' => 'Error'
        ], $response->getData(true));
    }
    public function test_return_error_response_with_custom_values(): void {
        $errors = ['email' => 'Email is required'];
        $response = $this->errorResponse($errors, 'Validation error', 422);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $errors
        ], $response->getData(true));
    }
    public function test_return_error_response_code_checks(): void {
        $response = $this->errorResponse([], 'Erros', 99); // The errorResponse will make any code that's not between 100 - 599 to 500 by default
        $this->assertEquals(500, $response->getStatusCode());
    }
}
