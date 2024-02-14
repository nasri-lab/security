# Phase 1: Security Audit

## Steps

### Step 1
Attempt to bypass the login form using SQL injection. In most sites vulnerable to injections, you can inject SQL code into the login field (username, email).

**Tip: To proceed safely, display the SQL queries generated during your work.**

Once you bypass the login form, try to note the profile that was assigned to you. Is it a regular user or an administrator profile? **Note it down, it's important.**

### Step 2

Once logged in, navigate through the application and look for pages with URLs containing parameters. If these pages display products by category or users by profile, and if this category/profile is passed as a parameter, then these pages are a real security flaw, and the entry point into these pages is the **URL**.

Technically, the query used in these pages to retrieve the list of products/users should be like:

```sql
Select …. FROM …. WHERE …. and id_cat = <ID>
```
Note that if we pass an **id** followed by SQL code like:
```sql
UNION Select …
```

The query becomes:
```sql
Select …. FROM …. WHERE …. and id_cat = <ID> UNION Select …
``` 
Result: the page will display the union of the two queries, and we **succeed**.

Perform this exercise on the products page (products.php), and display the values 1, 1, 1 at the bottom of the products.

**Tip:** The following query returns 3 columns with values 1, 1, 1:

```sql
Select 1, 1, 1
``` 

Step 3

Instead of "1, 1, 1", display the name of the database.

**Tip:** The following query displays the name of the database:

```sql
select database();
```


### Step 4

In Phpmyadmin, navigate to the **information_schema** database, especially the **SCHEMATA** table. Notice that you can retrieve the list of databases from this table. Display the names of the databases instead of "1, 1, 1".

### Step 5

Navigate to the **TABLES** table in the **information_schema** database. Notice that you can retrieve the list of tables from your database if you have its name. Display the names of the tables from your database instead of "1, 1, 1".

### Step 6

Continue until you retrieve user account information.

### Step 7

If you succeed in step 6, you will find that the password of the first user is: **4477f32a354e2af4c768f70756ba6a90**. It seems that this password is hashed. Try to decrypt it using one of the available tools:
[https://www.google.com/search?q=sha1+md5+decrypt](https://www.google.com/search?q=sha1+md5+decrypt)

## Summary

At this stage, note that you have been able to:

- Bypass the authentication process
- Access all the databases on your server
- Access your database's data
- Retrieve user account passwords

# Phase 2: Implementation of Security Measures

**Règle générale : On commence par régler les problèmes feuilles, puis les problèmes racines.**

## Mesures au niveau de la base de données :

1. Appliquer **un salt** au mot de passe, pour éviter que le hashage ne soit réversible.
2. Si une attaque survient, l’attaquant ne doit pas avoir le pouvoir d’admin. Pour ce faire, le premier compte utilisateur dans table doit avoir le moins de privilèges et ne doit pas être actif (si vous avez une colonne actif/inactif).
3. Eviter d’utiliser le compte « root » pour accéder à votre base de données, créez un utilisateur qui n’accède qu’à la base de données utilisée. Ceci évite que l'attaquant accède à la base de données **information_schema** et n'aura donc pas d'information sur les bases de données, les tables et les colonnes.

**Résultat : A ce niveau-là, même si l’injection SQL est possible, aucune donnée ne peut être récupérée, ni exploitée.**

## Mesures au niveau du code source :

4. Maintenant corrigez l’injection SQL sur la page des produits. 
5. Sur la page de login corrigez le code source pour bloquer l’injection.

