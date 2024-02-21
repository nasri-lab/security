Anglais - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab2-fr.md)

# Phase 1 : Application

## Étapes

### Étape 0 : Configuration de l'environnement

Avant de commencer le laboratoire, assurez-vous que le projet est en cours d'exécution sur votre environnement local. Si ce n'est pas déjà fait, suivez ces étapes :

1. Téléchargez le dépôt du projet depuis [GitHub](https://github.com/nasri-lab/security).
2. Exécutez le projet sous **Docker** ou en utilisant un outil tel que **Wamp** ou **XAMPP**.
3. Accédez au projet à l'adresse : [http://localhost:8000](http://localhost:8000).
4. Accédez à PhpMyAdmin à l'adresse : [http://localhost:8080](http://localhost:8080). Connectez-vous avec `nom d'utilisateur: root, mot de passe: rootpassword`.

### Étape 1 : Contournement de la connexion

Essayez de contourner la page de connexion en accédant directement à d'autres pages, telles que `http://localhost:8080/categories.php`.

Remarquez que cette page est accessible sans authentification, ce qui indique que la connexion ne vous empêche pas d'accéder aux autres pages.

### Étape 2 : Gestion des sessions

Résolvez le problème identifié à l'Étape 1 en mettant en œuvre la gestion des sessions dans le processus de connexion et en appliquant des contrôles de session sur toutes les ressources, à l'exception des pages publiques (pages de login et de logout pour ce projet).

### Étape 3 : Contrôle d'accès basé sur les rôles

Déconnectez-vous, puis reconnectez-vous en utilisant un profil **user** (et non **admin**). Referez vous à la tables **account**.

Essayez d'accéder à `http://localhost:8080/add-user.php`. Malgré le fait qu'elle soit accessible, cette ressource est sensible et devrait être restreinte au profil **admin** seulement.

**Correction :** En haut de la page, vérifiez si l'utilisateur connecté a les permissions pour accéder à cette ressource (profil **admin**). Sinon, redirigez-le vers une page par défaut (par exemple, `categories.php`).

**Règle générale :** Chaque projet doit avoir une matrice Profil/Capacités, qui doit être respectée tout au long du processus de développement.

# Phase 2 : Sécurité de la base de données

### Étape 1 : Élévation de privilèges

Souvenez-vous du Lab 1 où nous avons accédé à toutes les bases de données du serveur via l'application web, ce qui constitue un exemple d'**Élévation de privilèges**.

**Correction :**  Utilisez (ou créer) un utilisateur de base de données avec un accès limité uniquement à la base de données de l'application. 

**Attention:** N'utilisez jamais l'utilisateur **root** pour accéder à votre base de données.

### Étape 2 : Contrôle d'accès au niveau des fonctions

Essayez d'effectuer une injection SQL pour exécuter des requêtes comme `DROP TABLE` ou `DROP DATABASE`. Si cela réussit, cela indique un problème de **Contrôle d'accès au niveau des fonctions**.

**Correction :** Modifiez les privilèges de l'utilisateur MySQL (utilisé) pour inclure uniquement les droits `SELECT`, `UPDATE`, `INSERT` et `DELETE`, en révoquant tous les autres.
