<?php

namespace App\Persistence\Repository;

use App\Helper\General;
use App\Http\Resources\EmployeeResource;
use App\Mail\TemplateMail;
use App\Models\User;
use App\Persistence\Interfaces\EmployeesRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeesRepository implements EmployeesRepositoryInterface
{
   protected $user;

   public function __construct(
      User $user
   )
   {
      $this->user = $user;
   }

   public function findByEmployee($id)
   {
      $result = $this->user
         ->where('profile', 'employee')
         ->where('id', $id)
         ->first();

         $resultArray = $result->toArray();
         if (isset($resultArray['id_gestor'])) {
            $response = Gate::inspect('viewEmployee', new User($resultArray));

            return [$response, $result];
         }
   }

   public function findAllEmployee()
   {
      $result = $this->user
      ->where('profile', 'employee')
      ->get();

      return $result;
   }

   public function editEmployee($dados, $id): bool
   {
      $dados['birthdate'] = General::formatDate($dados['birthdate']);
      $result = $this->user->find($id)->update($dados);

      if($result) {
         return true;
      } else {
         return false;
      }
   }

   public function deleteEmployee($id): bool
   {
      $result = $this->user->find($id)->delete();

      if($result) {
         return true;
      } else {
         return false;
      }
   }

   public function uploadEmployee($file) : bool{
      if ($file->hasFile('file')) {

         $filename = "file-employees.csv";
         Storage::disk('s3')->put('employees/' . $filename, file_get_contents($file->file('file')));

         Mail::to(Auth::user()->email)->send(new TemplateMail("Dados importados com sucesso!", "Arquivo CSV recebido"));
         return true;
      }
      return false;
   }
}