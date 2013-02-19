@echo off


echo Schema update
echo ============================
echo.

SET remoteSyncParameter=%1
SET dumpSql=%2
SHIFT & SHIFT


set filePath="../temp/remote-database-sync-needed.temp"	

call remove-temp.bat

if /i "%remoteSyncParameter%"=="--remote" GOTO :DOFILESTUFF
:AFTER


if "%dumpSql%"=="--dump-sql" goto :cond
if "%remoteSyncParameter%"=="--dump-sql" goto :cond
goto :skip

:cond
php.exe .\..\www\index.php orm:schema-tool:update  --complete --dump-sql
goto :continue

:skip
php.exe .\..\www\index.php orm:schema-tool:update  --complete --force	

:continue

php.exe .\..\www\index.php migrations:migrate --no-interaction

if exist %filePath%  (del /F %filePath% > NUL)

echo Done
exit

:DOFILESTUFF
echo Syncing with remote database
echo "" > %filePath%
GOTO AFTER
