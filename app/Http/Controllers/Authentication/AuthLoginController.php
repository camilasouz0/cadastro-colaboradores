<?php

namespace App\Http\Controllers\Authentication;

use App\Business\UseCases\EmployeesUserCases;
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
use App\Http\Resources\EmployeeResource;
use App\Mail\TemplateMail;
use Exception;
use Illuminate\Support\Facades\Mail;

class AuthLoginController extends ResponseController
{
   /**
     * @OA\Info(
     *     title="API Cadastro de Colaboradores",
     *     description="API para o cadastro de colaboradores",
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

    public function __construct(EmployeesUserCases $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @OA\Post(
     ** path="/api/v1/login",
     *   tags={"Authentication"},
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

            return $this->successResponse('Autenticado com sucesso!', 'EmployeeResource', [$response]); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     ** path="/api/v1/register",
     *   tags={"Authentication"},
     *   summary="Register",
     *   operationId="register",
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
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="cpf",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="city",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="state",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="birthdate",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           format="date",
     *           example="01/01/2000"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="profile",
     *      in="query",
     *      required=false,
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
     *   @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *   )
     *)
    */
    public function register(RegisterRequest $request) {
        try {

            $input = new RegisterInput($request->all());
            $this->useCase->register($input->toArray());
            Mail::to($input->toArray()['email'])->send(new TemplateMail("Cadastro realizado com sucesso!", "Recebemos o seu cadastro"));
            $this->successResponse('Cadastro realizado com sucesso!');
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());   
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }
}
