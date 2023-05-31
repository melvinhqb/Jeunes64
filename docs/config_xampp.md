# Lancement du site web avec XAMPP

Ce guide explique les étapes nécessaires pour lancer un site web en utilisant XAMPP.

## Étapes pour lancer le site web

1. Téléchargement et installation de XAMPP :

   - Rendez-vous sur le site officiel de XAMPP à l'adresse [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
   - Téléchargez la dernière version de XAMPP pour votre système d'exploitation.
   - Exécutez le programme d'installation et suivez les instructions pour installer XAMPP sur votre machine.

2. Déployer votre site web :
    - Téléchargez le dossier du site web
   - Déplacez le dossier du site web dans le dossier "htdocs" de XAMPP. Le chemin d'accès typique de ce dossier est :
     - Sur Windows : C:\xampp\htdocs\
     - Sur macOS : /Applications/XAMPP/htdocs/
     - Sur Linux : /opt/lampp/htdocs/
   - Configurer XAMPP pour envoyer des mail depuis Localhost en PHP
      [ici](config_mail.md)

3. Lancement du serveur Apache :

   - Démarrez XAMPP sur votre machine.
   - Dans l'interface de XAMPP Control Panel, cliquez sur le bouton "Start" à côté du module Apache pour démarrer le serveur.

4. Accéder à votre site web :

   - Ouvrez un navigateur web.
   - Dans la barre d'adresse, saisissez http://localhost/Jeunes64 pour accéder à la page d'accueil du siet web.

Note : Pour assurer une protection appropriée des fichiers, il est recommandé de configurer le fichier .htaccess. Le fichier .htaccess permet de restreindre l'accès aux fichiers sensibles. Le fichier .htaccess permet ici de limiter l'accès aux fichiers JSON mais peut être utilisé pour toute autre configuration de sécurité requise.