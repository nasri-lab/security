[English](https://github.com/nasri-lab/sql-injection/blob/main/labs/lab4-en.md) - Français

# Laboratoire 4 : Comprendre et Prévenir les Attaques XSS

## Objectif
L'objectif de ce laboratoire est de comprendre les attaques par Cross-Site Scripting (XSS), d'identifier comment elles peuvent être exploitées dans les applications web et d'apprendre les mesures nécessaires pour les prévenir.

## Phase 1 : Identifier les Vulnérabilités XSS

### Étape 0 : Préparer l'Environnement
Assurez-vous que le projet des laboratoires précédents est opérationnel dans votre environnement local.

### Étape 1 : Explorer les Vecteurs d'Attaque XSS
Familiarisez-vous avec les différents types d'attaques XSS : XSS stocké, XSS reflété et XSS basé sur le DOM. Pour ce laboratoire, nous nous concentrerons sur le XSS stocké et reflété.

### Étape 2 : Identifier les Points Vulnérables
1. Examinez le code de `add-product.php` et `products.php`. Identifiez comment les entrées utilisateur sont intégrées dans la sortie sans validation ni encodage appropriés.
2. Créez une entrée malveillante contenant du code JavaScript, tel que `<script>alert('XSS');</script>` ou `<script>alert("XSS");</script>`, et soumettez-la via le formulaire sur `add-product.php`.
3. Naviguez vers `products.php` et observez si le script s'exécute, indiquant une vulnérabilité XSS.

## Phase 2 : Exploiter les Vulnérabilités XSS

### Étape 1 : Créer une Charge Utile Malveillante
Développez une charge utile sophistiquée qui effectue une action observable, telle que :

1. Modifier le contenu de la page (ajouter des éléments DOM) : `<script>document.getElementById('').innerHTML="...";</script>`
2. Rediriger vers un site web différent : `<script>window.location.href="...";</script>`.

### Étape 2 : Tester la Charge Utile
Soumettez votre charge utile malveillante via la page `add-product.php` et notez son impact sur la page `products.php`.

## Phase 3 : Prévenir les Attaques XSS

### Étape 1 : Sanitiser les Entrées Utilisateur
Mettez en œuvre la sanitisation des entrées dans `add-product.php` pour éliminer ou encoder les caractères spéciaux des entrées utilisateur avant leur traitement ou leur stockage. Pour cela, implémentez des requêtes préparées.

``` PHP 
// Préparer et lier
$stmt = $conn->prepare("INSERT INTO product (libelle, category_id, description) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $libelle, $category_id, $description);
```

### Étape 2 : Encoder la Sortie
Ajustez `products.php` pour encoder les caractères spéciaux dans la sortie. Utilisez la fonction `htmlspecialchars()` de PHP pour encoder de manière sécurisée le contenu généré par les utilisateurs avant l'affichage.

### Étape 3 : Valider les Entrées
Appliquez une validation des entrées lorsque c'est possible pour assurer que les données correspondent aux formats attendus. Par exemple, vérifiez :
1. Les champs numériques pour confirmer qu'ils contiennent uniquement des chiffres avant le traitement.
2. Les champs d'email pour confirmer qu'ils contiennent uniquement des emails avant le traitement.
3. etc.

## Phase 4 : Tester les Corrections

### Étape 1 : Retester avec les Charges Utiles Précédentes
Tentez à nouveau d'exploiter la vulnérabilité XSS avec les mêmes charges utiles de la Phase 2 pour confirmer que la vulnérabilité a été efficacement traitée.

### Étape 2 : Revoir et Comprendre les Corrections
Revuez comment la sanitisation des entrées, l'encodage des sorties et la validation aident à prévenir les vulnérabilités XSS et à sécuriser les applications web.
