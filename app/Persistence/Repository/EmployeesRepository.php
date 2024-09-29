<?php

namespace App\Persistence\Repository;

use App\Models\User;

class EmployeesRepository implements EmployeesRepositoryInterface
{
   protected $portalFornecedorWS;
   protected $usuarioRepository;
   protected $fornecedor;
   protected $user;

   public function __construct(
      User $user
   )
   {
      $this->user = $user;
   }

   public function findByUser($dados) 
   {
      
   }
}