<?php

namespace App\Persistence\Interfaces;

use App\Http\InputOutput\LoginInput;
use App\Http\InputOutput\RegisterInput;

interface AuthUseCaseInterface
{
   public function login(LoginInput $dados): array;
   public function register(RegisterInput $dados): bool;
}