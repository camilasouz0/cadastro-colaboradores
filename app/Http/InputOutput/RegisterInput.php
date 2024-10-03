<?php
declare(strict_types=1); 
namespace App\Http\InputOutput;

use App\Trait\ObjectValueTrait;

class RegisterInput
{
   use ObjectValueTrait;
   protected $name;
   protected $email;
   protected $cpf;
   protected $city;
   protected $state;
   protected $password;
   protected $profile;
   protected $birthdate;

   public function __construct(array $params) {
      $this->name = $params['name'];
      $this->email = $params['email'];
      $this->cpf = $params['cpf'];
      $this->city = $params['city'];
      $this->state = $params['state'];
      $this->password = $params['password'];
      $this->profile = $params['profile'] ?? 'employee';
      $this->birthdate = $params['birthdate'];
   }
}