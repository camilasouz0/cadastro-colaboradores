<?php

namespace App\Persistence\Repository;

use App\Persistence\Interfaces\AuthUseCaseInterface;
use App\Http\InputOutput\LoginInput;
use App\Http\InputOutput\RegisterInput;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthRepository implements AuthUseCaseInterface
{
   protected $useCase;
   protected $users;

   public function __construct(User $users)
   {
      $this->users = $users;
   }

   public function login(LoginInput $credentials):array
   {
      try {
         $token = auth()->attempt(['email' => $credentials->getEmail(), 'password' => $credentials->getPassword()]);
         if ($token) {
            return  [
               'access_token' => $token,
               'token_type' => 'bearer',
               'expires_in' => auth()->factory()->getTTL()
            ];

         } else {
            return abort(401, 'Unauthorized');
         }
      } catch (Exception $th) {
         throw $th;
      }
   }

   public function register(RegisterInput $dados):bool
   {

      $result = $this->users->create([
         'email' => $dados->getEmail(),
         'name' => $dados->getName(),
         'password' => Hash::make($dados->getPassword())
      ]);
      
      if($result) {
         return true;
      }

      return false;
   }
}