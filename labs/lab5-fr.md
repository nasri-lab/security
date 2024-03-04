[English](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab5-en.md) - Français

# Laboratoire 5 : Comprendre et Prévenir les Attaques CSRF

## Objectif
L'objectif de ce laboratoire est de démontrer comment les attaques par Falsification de Requête entre Sites (CSRF) peuvent être exécutées et de mettre en œuvre des mesures pour prévenir de telles attaques dans les applications web.

## Contexte
Les attaques CSRF permettent à des sites web malveillants d'effectuer des actions au nom des utilisateurs authentifiés sans leur consentement. Ce laboratoire utilisera un exemple pratique pour illustrer une attaque CSRF et vous guidera dans la mise en œuvre de contre-mesures.

## Configuration
Assurez-vous que le projet des laboratoires précédents fonctionne dans votre environnement local.

Pour ce laboratoire, nous devons exécuter un projet distinct nommé `hacker-code`, qui simule un site web malveillant. Ce projet contiendra un fichier PHP nommé `game-downloads.php`. Ce fichier inclut un script conçu pour effectuer des requêtes AJAX non autorisées vers `add-user.php`.

**Note :** Bien que les deux projets soient exécutés sur votre machine à des fins de test, cette configuration vise à simuler un scénario réel. Dans un tel scénario, `project-code` représente une application légitime (comme une application bancaire, d'assurance ou client) qui est vulnérable aux attaques CSRF. Pendant ce temps, le second projet, `hacker-code`, représente une application malveillante hébergée ailleurs, conçue pour exploiter la vulnérabilité CSRF de l'application légitime.

## Phase 1 : Comprendre la Vulnérabilité CSRF

### Étape 1 : Examiner le Code Vulnérable
Ouvrez `game-downloads.php` et examinez le code JavaScript qui envoie automatiquement une requête POST vers `add-user.php` lorsque la page est chargée. Ce script tente d'ajouter un nouvel utilisateur avec des privilèges d'admin sans le consentement de l'utilisateur.

**Note :** Dans cet exemple, le script ajoute un utilisateur avec un profil admin, ce qui est assez dangereux. Cependant, des scénarios comme effectuer un virement bancaire ou altérer/supprimer des données sensibles pourraient être bien plus dangereux.

### Étape 2 : Simuler l'Attaque
1. Imaginez qu'un utilisateur admin authentifié visite `game-downloads.php` tout en étant connecté à l'application.
2. Le script s'exécute, envoyant la requête AJAX pour ajouter un nouvel utilisateur admin.
3. Remarquez comment l'action est effectuée sans le consentement explicite de l'admin, démontrant une attaque CSRF réussie.

Essayez vous-même. Connectez-vous à votre application, puis visitez cette page :
[http://localhost:8100/game-download.php](http://localhost:8100/game-download.php)

**ATTENTION :** Modifiez l'URL selon votre configuration.

## Phase 2 : Mise en Place de la Protection Générale contre CSRF

### Étape 1 : Générer un token CSRF Général
Modifiez le `index.php` (page du script de connexion) pour générer un token CSRF unique lors de la connexion de l'utilisateur. Ce token est stocké dans la session de l'utilisateur et sera utilisé pour tous les formulaires pendant la session de l'utilisateur.

Voici un exemple pour générer et stocker un token CSRF dans `index.php`. **Faites attention :** Uniquement lorsque la connexion réussit.

```php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
```

### Étape 2: Valider le token CSRF Token

Avant de traiter toute demande de formulaire (par exemple, dans add-user.php), validez le token CSRF reçu du formulaire ou de la requête AJAX par rapport au token stocké dans la session. Si les deux ne correspondent pas, rejetez la demande.

Exemple de validation du token CSRF dans add-user.php :

```php
session_start();
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}
```

### Étape 3 : Modify Your Forms

Assurez-vous que chaque formulaire inclut le token CSRF comme un champ caché. Démarrez la session PHP au début de chaque page ou formulaire où vous avez besoin d'accéder aux variables `$_SESSION`, puis utilisez le token CSRF stocké dans vos formulaires.

```php
<?php 
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<form action="add-user.php" method="post">
    <!-- Autres champs du formulaire ici -->
    
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
    
    <!-- Bouton de soumission du formulaire -->
</form>
```

Cet exemple montre comment inclure de manière sécurisée le token CSRF dans un formulaire, assurant ainsi que chaque soumission est vérifiée pour la protection contre les attaques CSRF.

## Phase 3 : Mise en place de la protection CSRF spécifique au formulaire

Pour renforcer la sécurité de votre application, il est essentiel de générer un token CSRF unique pour chaque formulaire. Cette approche assure que chaque soumission de formulaire est authentifiée individuellement, rendant votre application plus résiliente face aux attaques CSRF.

### Tâche : Générer un token pour Chaque Formulaire

Votre mission consiste à modifier chaque formulaire de votre application, comme ceux dans `add-user.php` et `add-product.php`, pour y inclure un token CSRF unique.

### Tâche : Tâche Avancée
Comme observé, une colonne "Supprimer" a été ajoutée à la page `products.php`, introduisant une fonctionnalité pour supprimer des produits. Chaque ligne contient un lien pour la suppression, formaté comme `delete-product.php?id=2`. Supprimer des produits basés uniquement sur l'ID fourni dans l'URL présente un risque de sécurité significatif, exposant la fonctionnalité à des attaques CSRF potentielles.

Pour atténuer ce risque et sécuriser le processus de suppression, suivez ces étapes :

1. Créez le script `delete-product.php`.
2. Mettez en œuvre une protection CSRF, voici les étapes pour mettre en œuvre la protection CSRF :
    a. Générer et stocker un token CSRF : Lors du rendu de `products.php`, générez un token CSRF unique pour chaque lien de suppression de produit. Stockez ce token dans la session de l'utilisateur.
    b. Modifier le lien de suppression : Mettez à jour les liens de suppression dans `products.php` pour inclure le token CSRF comme paramètre d'URL, tel que `delete-product.php?id=2&csrf_token=VOTRE_token_CSRF_ICI`.
    c. Valider le token CSRF dans `delete-product.php` : Avant d'exécuter la suppression, validez le token CSRF fourni dans l'URL par rapport au token stocké dans la session. Procédez à la suppression uniquement si les tokens correspondent.

**Bonne chance.**
