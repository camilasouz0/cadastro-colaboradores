<?php
namespace App\Persistence\Interfaces;

interface EmployeesRepositoryInterface
{
   public function findByUser();
   public function login($dados):array;
}