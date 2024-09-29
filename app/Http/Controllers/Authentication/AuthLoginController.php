<?php

namespace App\Http\Controllers\Authentication;
         
use App\Persistence\Interfaces\AuthUseCaseInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\ResponseController;
use App\Http\InputOutput\LoginInput;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\InputOutput\RegisterInput;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthLoginController extends ResponseController
{
    protected $useCase;

    public function __construct(AuthUseCaseInterface $useCase)
    {
        $this->useCase = $useCase;
    }

    public function login(LoginRequest $request) {
        try {

            $input = new LoginInput($request->all());
            $response = $this->useCase->login($input);

            return $this->successResponse($response); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }

    public function register(RegisterRequest $request) {
        try {

            $input = new RegisterInput($request->all());
            $response = $this->useCase->register($input);

            return $this->successResponse($response); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }
}
