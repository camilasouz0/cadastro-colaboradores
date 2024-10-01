<?php
namespace App\Persistence\Interfaces;

use App\Models\User;

interface EmployeesRepositoryInterface
{
   public function findByEmployee($dados): User;
   public function findAllEmployee(): array;
   public function editEmployee($dados, $id): bool;
   public function deleteEmployee($id): bool;
   public function uploadEmployee($dados) : bool;
}