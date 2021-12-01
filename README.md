# SYMFONY

## NOUVEAU PROJET

- ouvrir un nouveau terminal
- se rendre dans le dossier où l'in veut créer le projet (ex.: MAMP) :
```
cd chemin_vers_le_dossier_MAMP
```
- créer le projet avec composer (pas besoin de créer le dossier du projet) :
```
composer create-project symfony/website-skeleton nom_du_projet ^5.4 (ou ^5.4.* sur Windows)
```

## GIT

- créer un dépôt Git sur GitHub
- avec un terminal, se rendre dans le dossier du projet (cd ... ou VSC)
- initialiser un dépôt local :
```
git init
```
- lier le dépôt distant au dépôt local :
```
git remote add origin lien_du_dépôt_GitHub
```
- ajouter tous les fichiers :
```
git add *
```
- donner un nom au commit :
```
git commit -m "message_du_commit"
```
- récupérer les dernières modifications :
```
git pull origin main
```
- envoyer les modifications :
```
git push origin main
```
