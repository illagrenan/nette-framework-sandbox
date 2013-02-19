@echo off


echo Running ALL JOBS
echo =====================
echo.

call composer-jobs.bat
call update-schema.bat
call regenerate-proxies.bat
call remove-temp.bat
call update-schema.bat
call git-jobs.bat
call deploy.bat

echo All jobs done
echo Done
pause
