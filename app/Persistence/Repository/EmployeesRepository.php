<?php

namespace App\Persistence\Repository;

use App\Helper\General;
use App\Models\User;
use App\Persistence\Interfaces\EmployeesRepositoryInterface;

class EmployeesRepository implements EmployeesRepositoryInterface
{
   protected $user;

   public function __construct(
      User $user
   )
   {
      $this->user = $user;
   }

   public function findByEmployee($id): array
   {
      $result = $this->user
      ->where('profile', 'employee')
      ->where('id', $id)
      ->toArray();

      return $result;
   }

   public function findAllEmployee(): array
   {
      $result = $this->user
      ->where('profile', 'employee')
      ->toArray();

      return $result;
   }

   public function editEmployee($dados, $id): bool
   {
      $dados['birthdate'] = General::formatDate($dados['birthdate']);
      $result = $this->user->find($id)->update($dados);

      if($result) {
         return true;
      } else {
         return false;
      }
   }
}