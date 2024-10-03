<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\AuthRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class RegisterUseCase extends BaseAuthUseCases {

   public AuthRepositoryInterface $repository;

   public function execute(array $dados) {
      $this->validatePassword($dados['password'], $dados['birthdate']);
      $this->verifyIfAuthUserIsAdmin();

      return $this->repository->register($dados);
   }

   private function validatePassword(string $password, string $birthdate): void {
      $date = explode('/', $birthdate); 

      // Verifica se a senha contém ano do aniversário
      if (strpos($password, $date[2]) !== false) {
         throw new Exception('A senha não pode conter partes do ano de nascimento.');
      }
   }

   private function verifyIfAuthUserIsAdmin(): void {
      if(!(Auth::user() != null) && !(Auth::user()->profile == 'admin')) {
         throw new Exception('Usuario não pode registrar.');
      }
   }
}