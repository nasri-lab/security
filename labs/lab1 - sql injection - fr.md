# Phase 1 : Audit de sécurité

## Etapes

### Etape 1
Essayez de contourner via l’injection SQL le formulaire de login. Dans la plupart des sites vulnérables face à l’injection, vous pouvez injecter du SQL dans le champ du login.
Conseil : Pour avancer à pas sûrs, affichez les requêtes SQL générés le long de votre travail.
Une fois vous contournez le formulaire de login, essayez de noter votre profil, est ce que vous vous êtes connectez en tant que simple utilisateur ou en tant qu’administrateur. Notez-le, c’est important.

### Etape 2
Une fois connectés, naviguez dans l’application et chercher les pages ayant des URLs avec paramètres. Si ces pages affichent des produits par catégorie ou des utilisateurs par profil et que cette catégorie/profil est passé en paramètre, alors ces pages sont une vraie faille de sécurité, et la porte d’entrée est l’URL. Techniquement la requête derrière doit être du genre :
Select …. FROM …. WHERE …. and id_cat = <ID passé en param>
Si nous passons en paramètre un id suivi d’un morceau SQL du genre UNION Select … la page affichera l’union des deux requêtes.
Faites cet exercice sur la page des produits, et affichez les valeurs 1, 1, 1 en bas des produits.
Astuce : la requête « Select 1, 1, 1 » retourne 3 colonnes de valeurs 1, 1, 1.

### Etape 3
A la place de « 1, 1, 1 » affichez le nom de la base de données.
Astuce select database(); permet d’afficher le nom de la base de données.

### Etape 4
Dans Phpmyadmin, naviguez dans la base de données information_schema surtout la table « SCHEMATA », remarquez que vous pouvez récupérer depuis cette table la liste des bases de données de votre serveur. Afficher les noms des bases de données au lieu de « 1, 1, 1 »

### Etape 5
Dans Phpmyadmin, naviguez dans la base de données information_schema surtout la table « TABLES », remarquez que vous pouvez récupérer depuis cette table la liste des tabes de votre bases de données si vous avez son nom. Afficher les noms des tables de votre base de données au lieu de « 1, 1, 1 »

### Etape 6

Continuez jusqu’à ce que vous récupériez les informations des comptes utilisateurs.

### Etape 7
Le mot de passe étant : 4477f32a354e2af4c768f70756ba6a90, il semble être un mot de passe haché, essayé de le dé-hacher via un des outils disponibles :
[https://www.google.com/search?q=sha1+md5+decrypt](https://www.google.com/search?q=sha1+md5+decrypt)


## Synthèse

Arrivant à ce stade, vous avez pu :
- Contourner le processus d’authentification
- Accéder à toutes les bases de données de votre serveur
- Accéder aux données de votre bases de données
- Récupérer les mots de passe de vos comptes d’utilisateur

# Phase 2 : Implémentation des mesures de protection

** Règle générale**  : On commence par régler les problèmes feuilles, puis les problèmes racines.

## Mesures au niveau de la base de données :

1. Appliquer un salt au mot de passe, pour éviter que le hashage ne soit réversible
2. Si une attaque survient, l’attaquant ne doit pas avoir le pouvoir d’admin, pour ce faire, le premier compte utilisateur dans table doit avoir le moins de privilèges et ne doit pas être actif (si vous avez une colonne actif/inactif).
3. Eviter d’utiliser le compte « root » pour accéder à votre base de données, créez un utilisateur qui n’accède qu’à la base de données utilisée.

A ce niveau-là, même si l’injection SQL est possible, aucune donnée ne peut être récupérée, ni exploitée.

## Mesures au niveau du code source :

4. Maintenant corrigez l’injection SQL sur la page des produits. 
5. Sur la page de login corrigez le code source pour bloquer l’injection.

