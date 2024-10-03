<?php

namespace App\Http\Controllers\Api;

use App\Persistence\Interfaces\EmployeesRepositoryInterface;
use App\Business\UseCases\EmployeesUserCases;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\InputOutput\EditEmployeeInput;
use App\Http\Requests\EditEmployeeRequest;
use App\Http\Requests\UploadEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\FindAllEmployeeResource;
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
        list($response, $result) = $this->repository->findByEmployee($id);

        if ($response->allowed()) {
            return [
               'success' => true,
               'data' => EmployeeResource::collection($result),
            ];
         } else {
            return [
               'success' => false,
               'data' => $response->message(),
            ];
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
            $response = $this->repository->findAllEmployee();

            return $this->successResponse('Lista de colaboradores', 'FindAllEmployeeResource', $response); 
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

    /**
     * @OA\Delete(
     *     path="/api/v1/employee/delete/{id}",
     *     summary="Deletar um colaborador",
     *     description="Exclui um colaborador por ID",
     *     tags={"Employee"},
     *     @OA\Parameter(
     *         name="id",
     *         schema={"type":"integer"},
     *         in="path",
     *         description="Employee ID",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Colaborador excluído com sucesso"
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
    public function deleteEmployee($id) {
        try {
            $result = $this->useCases->deleteEmployee($id);

            return $this->successResponse('Colaborador deletado com sucesso!', $result); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/employee/upload",
     *     summary="Upload de arquivo de colaboradores",
     *     description="Faz o upload de um arquivo CSV contendo informações de colaboradores",
     *     tags={"Employee"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Arquivo CSV com informações dos colaboradores"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Arquivo enviado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação do arquivo"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"apiAuth": {}}}
     * )
    */

    public function uploadEmployee(UploadEmployeeRequest $request) {
        try {
            $result = $this->useCases->uploadEmployee($request);

            return $this->successResponse('Arquivo importado com sucesso!'); 
        } catch (HttpException $e) {
            return $this->errorResponse($e, [], $e->getStatusCode());
        } catch (Exception $e) {
            return $this->errorResponse($e, [], $e->getCode());
        }
    }

}
