@echo off
Rem Purge cache and generate proxies

echo Generate proxy classes
echo =====================
echo.

echo 1) Purge cache
echo.

call remove-temp.bat
if exist "../app/proxies" (rmdir /S /Q "../app/proxies" > NUL)

echo 2) Generating proxies
echo.

php.exe .\..\www\index.php orm:generate-proxies

echo Done
