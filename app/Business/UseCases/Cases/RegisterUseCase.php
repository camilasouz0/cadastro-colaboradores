<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\AuthRepositoryInterface;
use Exception;

class RegisterUseCase extends BaseAuthUserCases {

   public AuthRepositoryInterface $repository;

   public function execute(array $dados) {
      $this->validatePassword($dados['password'], $dados['birthdate']);

      $this->repository->register($dados);
   }

   private function validatePassword(string $password, string $birthdate): void {
      $date = explode('/', $birthdate); 

      // Verifica se a senha contém ano do aniversário
      if (strpos($password, $date[2]) !== false) {
         throw new Exception('A senha não pode conter partes do ano de nascimento.');
      }
  }
}