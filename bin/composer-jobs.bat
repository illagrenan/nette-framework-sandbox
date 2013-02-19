@echo off


echo Running Composer jobs
echo =====================
echo.

call composer status --working-dir=".\.."
call composer validate --working-dir=".\.."
call composer install --working-dir=".\.."
call composer update --working-dir=".\.."

echo Composer tasks done.
call remove-temp.bat
echo Done