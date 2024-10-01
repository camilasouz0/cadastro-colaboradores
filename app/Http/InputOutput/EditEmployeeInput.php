<?php
declare(strict_types=1); 
namespace App\Http\InputOutput;

use App\Trait\ObjectValueTrait;

class EditEmployeeInput
{
   use ObjectValueTrait;
   protected $name;
   protected $email;
   protected $birthdate;

   public function __construct(array $params) {
      $this->name = $params['name'];
      $this->email = $params['email'];
      $this->birthdate = $params['birthdate'];
   }
}