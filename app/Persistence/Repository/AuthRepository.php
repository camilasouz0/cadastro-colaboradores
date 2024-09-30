<?php

namespace App\Persistence\Repository;

use App\Persistence\Interfaces\AuthRepositoryInterface;
use App\Http\InputOutput\LoginInput;
use App\Http\InputOutput\RegisterInput;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AuthRepository implements AuthRepositoryInterface
{
   protected $useCase;
   protected $users;

   public function __construct(User $users)
   {
      $this->users = $users;
   }

   public function login(array $credentials):array
   {
      try {
         $token = auth()->attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);
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

   public function register(array $dados):bool
   {

      $result = $this->users->create($dados);
      
      if($result) {
         return true;
      }

      return false;
   }
}