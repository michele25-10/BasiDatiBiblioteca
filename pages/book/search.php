<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/connessione.php';
include_once __DIR__ . '/../../common/navbar.php';

$search_term = $_GET['title'] ?? '';
$books = [];

if ($search_term) {
    $stmt = $link->prepare("SELECT ISBN, title, publication_year, language FROM book WHERE title LIKE ?");
    $like = "%" . $search_term . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $link->query("SELECT ISBN, title, publication_year, language FROM book");
}

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricerca Libro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="/BasiDatiBiblioteca/assets/style/global.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 8px; width: 300px; }
        input[type="submit"] { padding: 8px 16px; }
        table { margin-top: 20px; border-collapse: collapse; width: 100%; color: white;}
        th {
            color: white; 
            background-color: #000000; 
            padding: 10px;
            border: 1px solid #ccc;
        }
        td {
    color: white; 
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #222; 
}
    </style>
</head>
<body>

<h2>🔍 Ricerca Libro per Titolo</h2>

<form method="GET">
    <input type="text" name="title" placeholder="Inserisci titolo (anche parziale)" value="<?= htmlspecialchars($search_term) ?>">
    <input type="submit" value="Cerca">
</form>

<?php if (!empty($books)): ?>
    <table>
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Titolo</th>
                <th>Anno Pubblicazione</th>
                <th>Lingua</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['ISBN']) ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['publication_year']) ?></td>
                    <td><?= htmlspecialchars($book['language']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nessun libro trovato.</p>
<?php endif; ?>

</body>
</html>
