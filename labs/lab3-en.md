English - [Français](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab3-fr.md)

# Phase 1: Application side

## Steps

### Step 0: Setup Environment

Before starting the lab, ensure the project is running in your local environment. If not already set up, follow these steps:

1. Download the project repository from [GitHub](https://github.com/nasri-lab/security).
2. Run the project using **Docker**, or a local server solution like **Wamp** or **XAMPP**.
3. Access the project at `http://localhost:8000`.
4. Access PhpMyAdmin at `http://localhost:8080/`. Log in with `username: root` and `password: rootpassword`.

### Step 1: Enforce Strong Password Encryption

Recall from lab 1 that if a hacker succeeds in accessing your **account** table and retrieves your users' passwords, they might be able to decrypt them if they are hashed using old, outdated, or broken encryption algorithms, such as MD5, SHA1, or DES.

Given these two ciphered passwords:
`4477f32a354e2af4c768f70756ba6a90`
`da221472821d04cb95e9fb28591dd624`

It is easy to find the corresponding clear passwords using one of [these websites](https://www.google.com/search?channel=fs&client=ubuntu&q=Decrypt+MD5):
- `4477f32a354e2af4c768f70756ba6a90` corresponds to `pa55w0rd1`
- `da221472821d04cb95e9fb28591dd624` corresponds to `pa55w0rd2`

**Fix:** Update your the PHP source code to use a stronger and modern encryption algorithm like bcrypt, Argon2, or scrypt.

### Step 2: Salting Passwords Using Custom Code

To salt passwords manually in your code (in user add  page):
1. When adding a new user, create a **salt** string.
2. Before hashing the password, append the salt to it, then hash the result.
3. Store both the salt and the hashed password (add a `salt` column to the **account** table).

When verifying login credentials (in the login page):
1. First, locate the login row using the email only. So, update the SQL Query `SELECT ... WHERE email like ...`
2. Retrieve the salt.
3. Concatenate the salt and the entered password, then hash the result.
4. Compare the hashed salted password with the password stored in the `password` column.

### Step 3: Salting Passwords Using Built-in Functions

Use `password_hash` and `password_verify` for salting/hashing and verifying instead of the custom code described in Step 2.

# Phase 2: Server side

### Step 1: Sniff Passwords

Many tools can be used to sniff passwords sent in plaintext over the network to the server; ZAP Proxy, Fiddler, etc. You can see [here a short video for ZAP Proxy](https://www.youtube.com/watch?v=4C2d_nlZHiw).

Such tools allow sniffing all data transmitted in plaintext over the network, including passwords, credit card numbers, etc.

**TODO**:
1. Use ZAP proxy, and login to this application. Try retrieve via ZAP your login credentials.
2. Use ZAP proxy, and connect to your Gmail account. Try retrieve via ZAP your login credentials.

### Step 2: Implement HTTPS

**Fix:** To prevent this from happening, configure your server to use HTTPS instead of HTTP. In real-world applications, you need to obtain an SSL certificate.

**Caution:** Never use your passwords or enter sensitive data such as credit card numbers on a website running without HTTPS. You might inadvertently provide this data to a malicious party.
