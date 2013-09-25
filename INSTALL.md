Étapes d'installation
=====================


1) Setter le virtual host dans php.ini
--------------------------------------
    <VirtualHost *:80>
        ServerName bookies-app
        DocumentRoot "f:/www/gti710-bookies-app/web"
        DirectoryIndex app.php
        <Directory "f:/www/gti710-bookies-app/web">
            AllowOverride All
            Allow from All
        </Directory>
    </VirtualHost>

2) Setter le fichier host
-------------------------
Aller dans `C:\Windows\System32\drivers\etc` ouvrir le fichier host et ajouter cette ligne à la fin du fichier.
    
    127.0.0.1 bookies-app


3) Browsing the Demo Application
--------------------------------

