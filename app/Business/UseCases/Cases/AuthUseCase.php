<?php 
declare(strict_types=1); 
namespace App\Business\UseCase\Cases;

use App\Http\InputOutput\LoginInput;

class AuthUseCase extends BaseUserCases {

   public $repository;

   public function execute(LoginInput $dados) {
      $this->repository->login($dados);
   }
}