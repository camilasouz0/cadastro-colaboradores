<?php
namespace App\Persistence\Interfaces;

interface EmployeesRepositoryInterface
{
   public function findByEmployee($dados): array;
   public function findAllEmployee(): array;
   public function editEmployee($dados, $id): bool;
}