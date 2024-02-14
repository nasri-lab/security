[English](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab1-en.md) - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab1-fr.md)

# Phase 1 : Audit de sécurité

## Étapes

### Étape 1
Essayez de contourner le formulaire de connexion en utilisant une injection SQL. Dans la plupart des sites vulnérables aux injections, vous pouvez injecter du code SQL dans le champ de connexion (identifiant, nom d'utilisateur ou e-mail).

**Conseil : Pour avancer en toute sécurité, affichez les requêtes SQL générées pendant votre travail.**

Une fois le formulaire de connexion contourné, essayez de noter le profil qui vous a été affecté. S'agit-il d'un simple utilisateur ou d'un profil administrateur ? **Notez-le, c’est important.**

### Étape 2

Une fois connecté, naviguez dans l’application et recherchez les pages ayant des URLs avec des paramètres. Si ces pages affichent des produits par catégorie ou des utilisateurs par profil et que cette catégorie/profil est passée en paramètre, alors ces pages sont une vraie faille de sécurité, et la porte d’entrée dans ces pages est l'***URL***.

Techniquement, la requête utilisée dans ces pages pour récupérer la liste des produits/utilisateurs doit être du genre :

```sql
Select …. FROM …. WHERE …. and id_cat = <ID passé en param>
```
Remarquez que si nous passons en paramètre un **id** suivi d'un code SQL du genre :
```sql
UNION Select …
```

La requête devient : 
```sql
Select …. FROM …. WHERE …. and id_cat = <ID passé en param> UNION Select …
``` 

Résultat, la page affichera l’union des deux requêtes, et c'est **gagné**.

Faites cet exercice sur la page des produits (products.php), et affichez les valeurs 1, 1, 1 en bas des produits.

**Astuce :** la requête suivante renvoie 3 colonnes de valeurs 1, 1, 1 :
```sql
Select 1, 1, 1
``` 

### Etape 3

A la place de « 1, 1, 1 » affichez le nom de la base de données.

**Astuce :** la requête suivante permet d’afficher le nom de la base de données.

```sql
select database();
```

### Etape 4

Au niveau de l'outil Phpmyadmin, naviguez dans la base de données **information_schema** surtout la table **SCHEMATA**, remarquez que vous pouvez récupérer depuis cette table la liste des bases de données de votre serveur. Afficher les noms des bases de données au lieu de « 1, 1, 1 ».

### Etape 5

Naviguez dans table **TABLES** de la base de données **information_schema**, remarquez que vous pouvez récupérer depuis cette table la liste des tabes de votre bases de données si vous avez son nom. 

Afficher les noms des tables de votre base de données au lieu de « 1, 1, 1 ».

### Etape 6

Continuez jusqu’à ce que vous récupériez les informations des comptes utilisateurs.

### Etape 7

Si vous réussissez l'étape 6, vous trouverez que le mot de passe du premeir utilisateur est : **4477f32a354e2af4c768f70756ba6a90**, il semble que ce mot de passe est haché, essayez de le déchiffrer via l'un des outils disponibles :
[https://www.google.com/search?q=sha1+md5+decrypt](https://www.google.com/search?q=sha1+md5+decrypt)

## Synthèse

Arrivant à ce stade, notez que vous avez pu :
- **Contourner** le processus d’**authentification**
- **Accéder** à toutes les **bases de données de votre serveur**
- Accéder aux données de votre bases de données
- **Récupérer** les mots de passe de vos comptes d’utilisateur

# Phase 2 : Implémentation des mesures de protection

**Règle générale : On commence par régler les problèmes feuilles, puis les problèmes racines.**

## Mesures au niveau de la base de données :

1. Appliquer **un salt** au mot de passe, pour éviter que le hashage ne soit réversible.
2. Si une attaque survient, l’attaquant ne doit pas avoir le pouvoir d’admin. Pour ce faire, le premier compte utilisateur dans table doit avoir le moins de privilèges et ne doit pas être actif (si vous avez une colonne actif/inactif).
3. Eviter d’utiliser le compte « root » pour accéder à votre base de données, créez un utilisateur qui n’accède qu’à la base de données utilisée. Ceci évite que l'attaquant accède à la base de données **information_schema** et n'aura donc pas d'information sur les bases de données, les tables et les colonnes.

**Résultat : A ce niveau-là, même si l’injection SQL est possible, aucune donnée ne peut être récupérée, ni exploitée.**

## Mesures au niveau du code source :

4. Maintenant corrigez l’injection SQL sur la page des produits. 
5. Sur la page de login corrigez le code source pour bloquer l’injection.

