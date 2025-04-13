@ECHO OFF 
:: This batch file starts php on port on your local nviroment.
TITLE Live Server
ECHO Please wait... starting server

:: php server init.
php -S localhost:8080

PAUSE