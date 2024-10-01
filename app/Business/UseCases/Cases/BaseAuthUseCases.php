<?php 
declare(strict_types=1); 
namespace App\Business\UseCases\Cases;

use App\Persistence\Interfaces\AuthRepositoryInterface;

class BaseAuthUseCases {

   public AuthRepositoryInterface $repository;

   public function __construct(AuthRepositoryInterface $repository){
      $this->repository = $repository;
   }
}