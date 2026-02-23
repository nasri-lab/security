<?php 
require_once("../config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #34495e; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #eee; color: #444; font-size: 14px; }
        tr:hover { background-color: #f1f4f6; }

        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .role-admin { background-color: #e67e22; color: white; }
        .role-user { background-color: #bdc3c7; color: #2c3e50; }
        
        .pwd-cell { font-family: monospace; color: #95a5a6; font-size: 11px; }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>Gestion des Utilisateurs</h1>

    <?php 
        $result = $conn->query("SELECT * FROM account");

        if ($result->num_rows <= 0) {
            echo '<p>Aucun utilisateur trouvé.</p>'; 
        } else {
    ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Profil</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): 
                    $roleClass = ($row["profile"] === 'admin') ? 'role-admin' : 'role-user';
                ?>
                    <tr>
                        <td>#<?php echo $row["id"]; ?></td>
                        <td><strong><?php echo $row["name"]; ?></strong></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td>
                            <span class="role-badge <?php echo $roleClass; ?>">
                                <?php echo $row["profile"]; ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php 
        }
        $conn->close(); 
    ?>
</div>

</body>
</html>