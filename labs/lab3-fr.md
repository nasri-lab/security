Français - [Englais](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab3-en.md)

# Phase 1 : Côté application

## Étapes

### Étape 0 : Configuration de l'environnement

Avant de commencer le laboratoire, assurez-vous que le projet fonctionne dans votre environnement local. Si ce n'est pas déjà fait, suivez ces étapes :

1. Téléchargez le dépôt du projet depuis [GitHub](https://github.com/nasri-lab/security).
2. Lancez le projet en utilisant **Docker**, ou une solution de serveur local comme **Wamp** ou **XAMPP**.
3. Accédez au projet à l'adresse `http://localhost:8000`.
4. Accédez à PhpMyAdmin à l'adresse `http://localhost:8080/`. Connectez-vous avec `nom d'utilisateur : root` et `mot de passe : rootpassword`.

### Étape 1 : Appliquer un cryptage fort des mots de passe

Rappelez-vous du laboratoire 1 que si un pirate réussit à accéder à votre table **account** et récupère les mots de passe de vos utilisateurs, il pourrait être possible de les déchiffrer s'ils sont hashés en utilisant des algorithmes de cryptage vieux, obsolètes ou cassés, tels que MD5, SHA1 ou DES.

Étant donné ces deux mots de passe chiffrés :
`4477f32a354e2af4c768f70756ba6a90`
`da221472821d04cb95e9fb28591dd624`

Il est facile de trouver les mots de passe clairs correspondants en utilisant l'un de [ces sites web](https://www.google.com/search?channel=fs&client=ubuntu&q=Decrypt+MD5) :
- `4477f32a354e2af4c768f70756ba6a90` correspond à `pa55w0rd1`
- `da221472821d04cb95e9fb28591dd624` correspond à `pa55w0rd2`

**Correction :** Mettez à jour le code source PHP pour utiliser un algorithme de cryptage plus fort et moderne comme bcrypt, Argon2 ou scrypt.

### Étape 2 : Salage des mots de passe avec du code personnalisé

Pour saler les mots de passe manuellement dans votre code (dans la page d'ajout d'utilisateur) :
1. Lors de l'ajout d'un nouvel utilisateur, créez une chaîne **salt**.
2. Avant de hasher le mot de passe, ajoutez le salt à celui-ci, puis hashez le résultat.
3. Stockez à la fois le salt et le mot de passe hashé (ajoutez une colonne `salt` à la table **account**).

Lors de la vérification des identifiants de connexion (dans la page de connexion) :
1. Tout d'abord, localisez la ligne de connexion en utilisant uniquement l'email. Ainsi, mettez à jour la requête SQL `SELECT ... WHERE email like ...`
2. Récupérez le salt.
3. Concaténez le salt et le mot de passe saisi, puis hashez le résultat.
4. Comparez le mot de passe salé et hashé avec le mot de passe stocké dans la colonne `password`.

### Étape 3 : Salage des mots de passe avec des fonctions intégrées

Utilisez `password_hash` et `password_verify` pour saler/hasher et vérifier au lieu du code personnalisé décrit à l'Étape 2.

# Phase 2 : Côté serveur

### Étape 1 : Sniffer les mots de passe

De nombreux outils peuvent être utilisés pour sniffer les mots de passe envoyés en clair sur le réseau vers le serveur ; ZAP Proxy, Fiddler, etc. Vous pouvez voir [ici une courte vidéo pour ZAP Proxy](https://www.youtube.com/watch?v=4C2d_nlZHiw).

Ces outils permettent de sniffer toutes les données transmises en clair sur le réseau, y compris les mots de passe, les numéros de carte de crédit, etc.

**À FAIRE** :
1. Utilisez ZAP proxy et connectez-vous à cette application. Essayez de récupérer via ZAP vos identifiants de connexion.
2. Utilisez ZAP proxy et connectez-vous à votre compte Gmail. Essayez de récupérer via ZAP vos identifiants de connexion.

### Étape 2 : Implémenter HTTPS

**Correction :** Pour protéger contre le sniffing de données sensibles, configurez votre serveur pour utiliser HTTPS au lieu de HTTP. Pour les applications réelles, il est nécessaire d'obtenir un certificat SSL.

**Attention :** N'utilisez jamais vos mots de passe ou n'entrez pas de données sensibles telles que des numéros de carte de crédit sur un site web fonctionnant sans HTTPS. Vous pourriez involontairement fournir ces données à une partie malveillante.
