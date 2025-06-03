<?php
require_once __DIR__ . '/../../config/connessione.php';
include_once __DIR__ . '/../../common/navbar.php';

$allowed_columns = ['serial_number', 'name', 'surname'];
$column = $_GET['sort'] ?? 'surname';
$direction = $_GET['dir'] ?? 'asc';

if (!in_array($column, $allowed_columns)) {
    $column = 'surname';
}
$direction = strtolower($direction) === 'desc' ? 'DESC' : 'ASC';

$sql = "SELECT serial_number, name, surname, telephone, address 
        FROM user 
        ORDER BY $column $direction";

$result = $link->query($sql);
$utenti = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $utenti[] = $row;
    }
}

function build_sort_link($col, $current, $dir) {
    $new_dir = ($col === $current && $dir === 'asc') ? 'desc' : 'asc';
    return "?sort=$col&dir=$new_dir";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elenco Utenti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="/BasiDatiBiblioteca/assets/style/global.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #222;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f0f0f0;
            color: black;
        }
        td {
            color: white;
        }
        a.sort-link {
            color: black;
            text-decoration: none;
        }
        a.sort-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Elenco Utenti Biblioteca</h2>

<?php if (!empty($utenti)): ?>
    <table>
        <thead>
            <tr>
                <th><a class="sort-link" href="<?= build_sort_link('serial_number', $column, $direction) ?>">Serial Number</a></th>
                <th><a class="sort-link" href="<?= build_sort_link('name', $column, $direction) ?>">Nome</a></th>
                <th><a class="sort-link" href="<?= build_sort_link('surname', $column, $direction) ?>">Cognome</a></th>
                <th>Telefono</th>
                <th>Indirizzo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utenti as $utente): ?>
                <tr>
                    <td><?= htmlspecialchars($utente['serial_number']) ?></td>
                    <td><?= htmlspecialchars($utente['name']) ?></td>
                    <td><?= htmlspecialchars($utente['surname']) ?></td>
                    <td><?= htmlspecialchars($utente['telephone']) ?></td>
                    <td><?= htmlspecialchars($utente['address']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nessun utente registrato.</p>
<?php endif; ?>

</body>
</html>
