<?php

namespace App\Persistence\Repository;

use App\Helper\General;
use App\Http\Resources\EmployeeResource;
use App\Mail\TemplateMail;
use App\Models\User;
use App\Persistence\Interfaces\EmployeesRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeesRepository implements EmployeesRepositoryInterface
{
   protected $user;
   protected $authRepository;

   public function __construct(
      User $user,
      AuthRepository $authRepository
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

         $this->processFile($file->file('file'));

         return true;
      }
      return false;
   }

   private function processFile($file)
   {
      $handle = fopen($file->getRealPath(), 'r');   
      $row = 0;
      $header = null;
      $user = [];
      while (($data = fgetcsv($handle, 1000, ",")) !== false) {
         if ($row === 0) {
            $header = $data;
         } else {
            if($header) {
               try {
                  $user = array_combine($header, $data);
                  $this->user->create([
                     'name' => $user['name'] ?? null,
                     'email' => $user['email'] ?? null,
                     'cpf' => $user['cpf'] ?? null,
                     'city' => $user['city'] ?? null,
                     'state' => $user['state'] ?? null,
                     'birthdate' => date('Y-m-d'),
                     'password' => 'Ch4ngemeAfterLogin',
                     'id_gestor' => Auth::user()->id
                  ]);
               } catch (Exception $e) {
                  continue;
               }
            }
         }
         $row++;
      }
      fclose($handle);
   }
   
}   