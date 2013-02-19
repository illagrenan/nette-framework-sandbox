@echo off


echo Running GIT jobs
echo =====================
echo.

set /P theuserinput="Enter GIT commit message: "
echo %theuserinput%

call git add .
call git commit -a -m "%theuserinput%"
call git push
call git pull

echo Composer tasks done.
call remove-temp.bat

echo Done