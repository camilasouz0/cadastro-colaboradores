<?php
namespace App\Persistence\Interfaces;

interface EmployeesRepositoryInterface
{
   public function findByEmployee($dados);
   public function findAllEmployee();
   public function editEmployee($dados, $id): bool;
   public function deleteEmployee($id): bool;
   public function uploadEmployee($dados) : bool;
}