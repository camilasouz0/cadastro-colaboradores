<?php

namespace App\Persistence\Interfaces;

interface AuthRepositoryInterface
{
   public function login(array $dados): array;
   public function register(array $dados): bool;
}