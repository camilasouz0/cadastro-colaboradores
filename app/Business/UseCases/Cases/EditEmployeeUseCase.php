<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\EmployeesRepositoryInterface;

class EditEmployeeUseCase extends BaseUserCases {

   public EmployeesRepositoryInterface $repository;

   public function execute(array $dados, int $id) {
      $this->repository->editEmployee($dados, $id);
   }
}