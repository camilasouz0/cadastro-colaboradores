#/bin/bash

composer dumpautoload && php artisan config:clear && php artisan l5-swagger:generate