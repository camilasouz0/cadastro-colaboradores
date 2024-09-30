<?php

namespace App\Business\UseCases;

use App\Business\UseCases\Cases\LoginUseCase;

class EmployeesUserCases {

   protected $loginUseCase;
   public function __construct(
      LoginUseCase $loginUseCase
   )
   {
      $this->loginUseCase = $loginUseCase;
   }

   public function login($dados) {
      $this->loginUseCase->execute($dados);
   }
}