<?php

namespace App\Http\Controllers\Authentication;
         
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Persistence\Interfaces\AuthRepositoryInterface;
use App\Http\Controllers\ResponseController;
use App\Http\InputOutput\{
    RegisterInput,
    LoginInput
};
use App\Http\Requests\{
    RegisterRequest,
    LoginRequest
};
use Exception;

class AuthLoginController extends ResponseController
{
    /**
     * @OA\Info(
     *     title="API cadastro de colaboradores",
     *     description="API cadastro de colaboradores",
     *     version="1.0.0",
     *     termsOfService="http://swagger.io/terms/",
     *     @OA\Contact(
     *         email="camilamaiara@hotmail.com.br"
     *     ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */

    protected $useCase;

    public function __construct(AuthRepositoryInterface $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @OA\Post(
     ** path="/api/v1/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
    */
    public function login(LoginRequest $request) {
        try {

            $input = new LoginInput($request->all());
            $response = $this->useCase->login($input->toArray());

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
            $response = $this->useCase->register($input->toArray());

            return $this->successResponse($response); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }
}
