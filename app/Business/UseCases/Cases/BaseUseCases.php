<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\EmployeesRepositoryInterface;

class BaseUseCases {

   public EmployeesRepositoryInterface $repository;

   public function __construct(EmployeesRepositoryInterface $repository){
      $this->repository = $repository;
   }
}