English - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab5-fr.md)

# Lab 5: Understanding and Preventing CSRF Attacks

## Objective
The objective of this lab is to demonstrate how Cross-Site Request Forgery (CSRF) attacks can be executed and to implement measures to prevent such attacks in web applications.

## Background
CSRF attacks allow malicious websites to perform actions on behalf of authenticated users without their consent. This lab will use a practical example to illustrate a CSRF attack and guide you through implementing countermeasures.

## Setup
Ensure the project from previous labs is running in your local environment. 

For this lab, we need to run a separate project named `hacker-code`, which simulates a malicious website. This project will contain a PHP file named `game-downloads.php`. This file includes a script designed to make unauthorized AJAX requests to `add-user.php`.

**Note:** Although both projects are run on your machine for testing purposes, this setup is meant to simulate a real-world scenario. In such a scenario, `project-code` represents a legitimate application (such as a banking, insurance, or client application) that is vulnerable to CSRF attacks. Meanwhile, the second project, `hacker-code`, represents a malicious application hosted elsewhere, designed to exploit the CSRF vulnerability in the legitimate application.

## Phase 1: Understanding CSRF Vulnerability

### Step 1: Examine the Vulnerable Code
Open `game-downloads.php` and review the JavaScript code that automatically sends a POST request to `add-user.php` when the page is loaded. This script attempts to add a new user with admin privileges without the user's consent.

**Note:** In this example, the script adds a user with an admin profile, which is dangerous enough. However, scenarios like executing a bank transfer or altering/deleting sensitive data might be way more dangerous.

### Step 2: Simulate the Attack
1. Imagine that an authenticated admin user visits `game-downloads.php` while logged into the application.
2. The script executes, sending the AJAX request to add a new admin user.
3. Notice how the action is performed without the admin's explicit consent, demonstrating a successful CSRF attack.

Try it yourself. Log in to your application, and then visit this page:
[http://localhost:8100/game-download.php](http://localhost:8100/game-download.php)

**BE CAREFUL:** Change the URL according to your configuration.

## Phase 2: Implementing General CSRF Protection

### Step 1: Generate a General CSRF Token
Modify the `index.php` (login script page) to generate a unique CSRF token upon user login. This token is stored in the user session and will be used for all forms during the user's session.

Here is an example for generating and storing CSRF token in `index.php`. **Be careful:** Only when the login succeeds.

```php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
```

### Step 2: Validate the CSRF Token

Before processing any form requests (e.g., in add-user.php), validate the CSRF token received from the form or AJAX request against the token stored in the session. If they do not match, reject the request.

Example for validating CSRF token in add-user.php:

```php
session_start();
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}
```

### Step 3: Modify Your Forms

Ensure each form includes the CSRF token as a hidden input field. Start the PHP session at the beginning of each page or form where you need to access `$_SESSION` variables, and then use the stored CSRF token within your forms.

```php
<?php 
    session_start();
    $csrf_token = $_SESSION['csrf_token'];
?>

<form action="your_action.php" method="post">
    <!-- Other form fields -->
    
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
    
    <!-- Submit button -->
</form>
```

This snippet demonstrates how to securely include the CSRF token in a form, ensuring that each submission is verified for CSRF protection.

## Phase 2: Implementing Form-specific CSRF Protection

To enhance the security of your application, it's essential to generate a unique CSRF token for each form. This approach ensures that each form submission is authenticated individually, making your application more resilient against CSRF attacks.

### Task: Generate a Token for Each Form

Your task is to modify each form in your application, such as those in `add-user.php` and `add-product.php`, to include a unique CSRF token.

### Task: Advanced task

As you may notice, a new column "Delete" has been added to the page the `products.php`, that aims to delete products. The link in each row is like: ...delete-product.php?id=2 
It is dangerous to delete products from the database based on the id only. This is really vulnerable to CSRF. 

1. Create the script delete-product.php, add the code for deleting a product whose id is given in the URL.
2. Implement CSRF protection to prevent from this attack. 

### Task: Advanced task
As observed, a "Delete" column has been added to the `products.php` page, introducing functionality to delete products. Each row contains a link for deletion, formatted as `delete-product.php?id=2`. Deleting products based solely on the ID provided in the URL poses a significant security risk, exposing the feature to potential CSRF attacks.

To mitigate this risk and secure the deletion process, follow these steps:

1. Create the delete-product.php Script
2. Implement CSRF Protection, here are the steps to Implement CSRF Protection:
    a. Generate and Store a CSRF Token: When rendering products.php, generate a unique CSRF token for each product deletion link. Store this token in the user's session.
    b. Modify the Deletion Link: Update the deletion links in `products.php` to include the CSRF token as a URL parameter, such as `delete-product.php?id=2&csrf_token=YOUR_CSRF_TOKEN_HERE`.
    c. Validate the CSRF Token in `delete-product.php`: Before executing the deletion, validate the CSRF token provided in the URL against the token stored in the session. Only proceed with the deletion if the tokens match.

**Good luck.**