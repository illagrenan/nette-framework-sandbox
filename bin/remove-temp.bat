@echo off

echo Purge cache
echo =====================
echo.

if exist "../temp/btfj.dat" (del /F "../temp/btfj.dat" > NUL)
if exist "../temp/cache" (rmdir /S /Q "../temp/cache" > NUL)
if exist "../www/webtemp" (rmdir /S /Q "../www/webtemp" > NUL)
if exist "../temp/log" (rmdir /S /Q "../temp/log" > NUL)
if exist "../log" (rmdir /S /Q "../log" > NUL)

mkdir "../log"
mkdir "../temp/cache"
mkdir "../www/webtemp"

echo "!.gitignore" > "../temp/.gitignore"
echo "!.gitignore" > "../temp/cache/.gitignore"
echo "!.gitignore" > "../temp/sessions/.gitignore"
echo "!.gitignore" > "../www/webtemp/.gitignore"
echo "!.gitignore" > "../log/.gitignore"

echo Done. Cache cleared.