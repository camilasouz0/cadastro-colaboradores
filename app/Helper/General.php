<?php

namespace App\Helper;

use Carbon\Carbon;

class General
{
   public static function formatDate($value)
   {
      $date = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');

      return $date;
   }
}