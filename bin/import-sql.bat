@echo off


echo Importing SQL
echo ============================
echo.

set ROOT=.\..\app\sql\
SET remoteSyncParameter=%1
set filePath="../temp/remote-database-sync-needed.temp"	

if /i "%remoteSyncParameter%"=="--remote" GOTO :DOFILESTUFF
:AFTER

FOR /F "DELIMS==" %%f in ('DIR "%ROOT%*.sql" /B') DO (
	php.exe .\..\www\index.php dbal:import %ROOT%%%f
)

exit

:DOFILESTUFF
echo Syncing with remote database
echo "" > %filePath%
GOTO AFTER