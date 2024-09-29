<?php
declare(strict_types=1); 
namespace App\Http\InputOutput;

class RegisterInput
{
   protected string $name;
   protected string $email;
   protected string $password;

   public function __construct(array $params) {
      $this->name = $params['name'];
      $this->email = $params['email'];
      $this->password = $params['password'];
   }

   public function getName(): string {
      return $this->name;
   }

   public function getEmail(): string {
      return $this->email;
   }

   public function getPassword(): string {
      return $this->password;
   }
   
}