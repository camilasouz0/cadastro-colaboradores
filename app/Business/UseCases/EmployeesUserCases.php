<?php

namespace App\Business\UseCases;

use App\Business\UseCase\Cases\AuthUseCase;

class EmployeesUserCases {

   protected $authUseCase;
   public function __construct(
      AuthUseCase $authUseCase
   )
   {
      $this->authUseCase = $authUseCase;
   }

   public function login($dados) {
      $this->authUseCase->execute($dados);
   }
}