<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\EmployeesRepositoryInterface;

class UploadEmployeeUseCase extends BaseUseCases {

   public EmployeesRepositoryInterface $repository;

   public function execute(int $id) {
      $this->repository->uploadEmployee($id);
   }
}