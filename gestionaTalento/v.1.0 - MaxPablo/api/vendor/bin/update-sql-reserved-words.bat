@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../mysql-workbench-schema-exporter/mysql-workbench-schema-exporter/bin/update-sql-reserved-words
php "%BIN_TARGET%" %*
