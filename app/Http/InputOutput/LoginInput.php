<?php
declare(strict_types=1); 
namespace App\Http\InputOutput;

class LoginInput
{
   protected string $email;
   protected string $password;

   public function __construct(array $params) {
      $this->email = $params['email'];
      $this->password = $params['password'];
   }

   public function getEmail(): string {
      return $this->email;
   }

   public function getPassword(): string {
      return $this->password;
   }
   
}