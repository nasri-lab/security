English - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab2-fr.md)

# Phase 1: Application 

## Steps

### Step 0: Setup Environment

Before starting the lab, ensure the project is running in your local environment. If not already set up, follow these steps:

1. Download the project repository from [GitHub](https://github.com/nasri-lab/security).
2. Run the project using **Docker**, or a local server solution like **Wamp** or **XAMPP**.
3. Access the project at `http://localhost:8000`.
4. Access PhpMyAdmin at `http://localhost:8080/`. Log in with `username: root` and `password: rootpassword`.

### Step 1: Bypass the Login

Attempt to bypass the login page by directly accessing other pages, such as `http://localhost:8080/categories.php`.

Notice that this page is accessible without authentication, indicating that the login does not prevent unauthorized access.

### Step 2: Session Management

Address the issue identified in Step 1 by implementing session management within the login process and enforcing session checks on all resources except public ones (login and logout pages for this project).

### Step 3: Role-Based Access Control

After logging out, log in again using a **user** profile (not an **admin**). Refer to **account** table.

Attempt to access `http://localhost:8080/add-user.php`. Despite being accessible, this resource is sensitive and should be restricted to the **admin** profile only.

**Fix:** At the top of the page, verify if the logged-in user has the permissions to access this resource (**admin** profile). If not, redirect them to a default page (e.g., `categories.php`).

**General Rule:** Each project should have a Profile/Capabilities matrix, which must be adhered to throughout the development process.

# Phase 2: Database Security

### Step 1: Privilege Escalation

Recall from lab 1 that we accessed all server databases through the web application, an example of **Privilege Escalation**.

**Fix:** To prevent this, employ (or create) a database user with access restricted solely to the application's database.

**Caution:** Never user the **root** user to access your database.

### Step 2: Function-Level Access Control

Attempt SQL injection to execute queries like `DROP TABLE` or `DROP DATABASE`. Success indicates a problem with **Missing Function-Level Access Control**.

**Fix:** Modify the MySQL user (created in step 1 Phase 2) privileges to only include `SELECT`, `UPDATE`, `INSERT`, and `DELETE` capabilities, revoking all others (`ALTER`, `DROP`, etc.).
