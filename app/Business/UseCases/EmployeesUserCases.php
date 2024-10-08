<?php

namespace App\Business\UseCases;

use App\Business\UseCases\Cases\{
   UploadEmployeeUseCase,
   DeleteEmployeeUseCase,
   EditEmployeeUseCase,
   RegisterUseCase,
   LoginUseCase
};

class EmployeesUserCases {

   protected $loginUseCase;
   protected $registerUseCase;
   protected $editEmployeeUseCase;
   protected $deleteEmployeeUseCase;
   protected $uploadEmployeeUseCase;

   public function __construct(
      LoginUseCase $loginUseCase,
      RegisterUseCase $registerUseCase,
      EditEmployeeUseCase $editEmployeeUseCase,
      DeleteEmployeeUseCase $deleteEmployeeUseCase,
      UploadEmployeeUseCase $uploadEmployeeUseCase
   )
   {
      $this->loginUseCase = $loginUseCase;
      $this->registerUseCase = $registerUseCase;
      $this->editEmployeeUseCase = $editEmployeeUseCase;
      $this->deleteEmployeeUseCase = $deleteEmployeeUseCase;
      $this->uploadEmployeeUseCase = $uploadEmployeeUseCase;
   }

   public function login($dados): array {
      return $this->loginUseCase->execute($dados);
   }

   public function register($dados) {
      $this->registerUseCase->execute($dados);
   }

   public function editEmployee($dados, $id) {
      $this->editEmployeeUseCase->execute($dados, $id);
   }

   public function deleteEmployee($id) {
      $this->deleteEmployeeUseCase->execute($id);
   }

   public function uploadEmployee($dados) {
      $this->uploadEmployeeUseCase->execute($dados);
   }
}