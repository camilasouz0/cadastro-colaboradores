<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\AuthRepositoryInterface;

class LoginUseCase extends BaseAuthUseCases {

   public AuthRepositoryInterface $repository;

   public function execute(array $dados): array {
      return $this->repository->login($dados);
   }
}