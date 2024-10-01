<?php

namespace App\Business\UseCases;

use App\Business\UseCases\Cases\{
   EditEmployeeUseCase,
   RegisterUseCase,
   LoginUseCase
};

class EmployeesUserCases {

   protected $loginUseCase;
   protected $registerUseCase;
   protected $editEmployeeUseCase;

   public function __construct(
      LoginUseCase $loginUseCase,
      RegisterUseCase $registerUseCase,
      EditEmployeeUseCase $editEmployeeUseCase
   )
   {
      $this->loginUseCase = $loginUseCase;
      $this->registerUseCase = $registerUseCase;
      $this->editEmployeeUseCase = $editEmployeeUseCase;
   }

   public function login($dados) {
      $this->loginUseCase->execute($dados);
   }

   public function register($dados) {
      $this->registerUseCase->execute($dados);
   }

   public function editEmployee($dados, $id) {
      $this->editEmployeeUseCase->execute($dados, $id);
   }
}