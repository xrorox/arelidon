Author : frinux
Contact : contact@frinux.fr

This script allows you to make a backup of the databases and/or folders on your webserver.
In on click, backup all you need and store it on your server or on your own hard drive.

Move the folder 'backup' in the root folder of your website.
CAUTION : if you decide to rename it, please change the variable $folder_name in config.php

You must have a full access to these folders : sql and files (chmod 666).

You should protect the folder containing this script with a .htaccess, since it manipulates sensibles functions.

Requires the system functions :
 - tar
 - gzip
 - mysqldump
 
 TODO : gestion des erreurs