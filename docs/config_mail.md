# Comment configurer XAMPP pour envoyer des mail depuis Localhost en PHP ?

## Prérequis

La configuration de la messagerie necessite d'installer et de configurer le [logiciel XAMPP](config_xampp.md) au préalable.

## Etape 1

Accédez au (C:xampp\php) et ouvrez le fichier de paramètres de configuration PHP, puis recherchez le [mail function]en faisant défiler vers le bas ou appuyez simplement sur **ctrl + f** pour le rechercher directement, puis recherchez les lignes suivantes et transmettez ces valeurs. N'oubliez pas qu'il peut y avoir un point-virgule ; au début de chaque ligne, supprimez simplement le point-virgule de chaque ligne qui est donnée ci-dessous.

```ini
[ fonction mail ]
Pour Win32 uniquement.
http://php.net/smtp _
SMTP=smtp.gmail.com
http: //php.net/smtp-port
port_smtp= 587
sendmail_from = site.jeunes64@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

C'est tout pour ce fichier, appuyez sur **ctrl + s** pour enregistrer ce fichier, puis fermez-le.

## Etape 2

Maintenant, allez dans (C:\xampp\sendmail) et ouvrez le fichier de paramètres de configuration de `sendmail`, puis recherchez sendmailen faisant défiler vers le bas ou appuyez sur **ctrl+f** pour le rechercher directement, puis recherchez les lignes suivantes et transmettez ces valeurs. N'oubliez pas qu'il peut y avoir un point-virgule ; au début de chaque ligne, supprimez simplement le point-virgule de chaque ligne qui est donnée ci-dessous.

```ini
smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=site.jeunes64@gmail.com
auth_password=tarnmvybtwrizuia
force_sender=site.jeunes64@gmail.com (it's optional)
```

C'est tout pour ce fichier, appuyez sur **ctrl + s** pour enregistrer ce fichier, puis fermez-le. Après tous les changements dans les deux fichiers, n'oubliez pas de redémarrer votre serveur apache.

Maintenant, vous avez terminé avec les modifications requises dans ces fichiers.
