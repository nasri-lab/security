[English](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab1-en.md) - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab1-fr.md)

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

**General Rule: We start by addressing the leaf problems, then the root problems.**

## Database-level Measures:

1. Apply **a salt** to the password to prevent reversible hashing.
2. If an attack occurs, the attacker should not have admin privileges. To achieve this, the first user account in the table should have the fewest privileges and should not be active (if you have an active/inactive column).
3. Avoid using the "root" account to access your database; create a user who only has access to the database being used. This prevents the attacker from accessing the **information_schema** database and therefore from obtaining information about databases, tables, and columns.

**Result: At this level, even if SQL injection is possible, no data can be retrieved or exploited.**

## Source Code-level Measures:

4. Now fix the SQL injection on the products page.
5. On the login page, fix the source code to block injection.
