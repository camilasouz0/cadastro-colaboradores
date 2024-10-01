<?php

namespace App\Http\Controllers\Api;

use App\Persistence\Interfaces\EmployeesRepositoryInterface;
use App\Business\UseCases\EmployeesUserCases;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\InputOutput\EditEmployeeInput;
use App\Http\Requests\EditEmployeeRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeesController extends ResponseController
{
    /**
     * @OA\SecurityScheme(
     *    securityScheme="apiAuth",
     *    in="header",
     *    name="bearerAuth",
     *    type="http",
     *    scheme="bearer",
     *    bearerFormat="JWT"
     * )
     */

    protected EmployeesRepositoryInterface $repository;
    protected $useCases;

    public function __construct(
        EmployeesRepositoryInterface $repository,
        EmployeesUserCases $useCases
    )
    {
        $this->repository = $repository;
        $this->useCases = $useCases;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/employee/{id}",
     *     summary="Obter um colaborador",
     *     description="Retorna um colaborador por ID",
     *     operationId="getColaboradores",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         schema={"type":"integer"},
     *         in="path",
     *         description="User ID",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna um colaborador por ID"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"apiAuth": {}}}
     * )
     */

    public function findByEmployee($id) {

        $response = Gate::inspect('viewAny', Auth::user());
        $result = $this->repository->findByEmployee($id);

        dd($response);
        if ($response->allowed()) {
            return $result;
        } else {
            return $response->message();
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/employee/list",
     *     summary="Obter todos os colaboradores",
     *     description="Retorna uma lista com todos os colaborador",
     *     tags={"Employee"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma lista de colaboradores"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"apiAuth": {}}}
     * )
     */
    public function findAllEmployee(Request $request) {
        try {
            $result = $this->repository->findAllEmployee();

            return $this->successResponse($result); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/employee/edit/{id}",
     *     summary="Editar um colaborador",
     *     description="Atualiza os dados de um colaborador por ID",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         schema={"type":"integer"},
     *         in="path",
     *         description="Employee ID",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Camila Souza"),
     *             @OA\Property(property="email", type="string", example="camila@minhaempresa.com"),
     *             @OA\Property(property="birthdate", type="string",example="01/01/2000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do colaborador atualizados com sucesso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Colaborador não encontrado"
     *     ),
     *     security={{"apiAuth": {}}}
     * )
     */

    public function editEmployee($id, EditEmployeeRequest $request) {
        try {
            $input = new EditEmployeeInput($request->all());
            $result = $this->useCases->editEmployee($input->toArray(), $id);

            return $this->successResponse('Colaborador atualizado com sucesso!', $result); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }
}
