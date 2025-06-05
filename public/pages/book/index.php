<?php
require_once __DIR__ . '/../../config/connessione.php';

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
    <link rel="stylesheet" href="/assets/style/global.css">
    <style>
        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row;
            justify-content: start;
            gap: 10px;
            align-items:center;
        }

        .input-btn-success{
            background-color: #28a745 !important;
            color: white !important; 
        }

        table { margin-top: 20px; border-collapse: collapse; width: 100%; color: black;}
        th {
            padding: 10px;
            border: 1px solid #ccc;
        }
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>
    <div class="container">
        <h2>Ricerca Libro per Titolo</h2>

        <form method="GET">
            <input type="text" name="title" placeholder="Inserisci titolo (anche parziale)" value="<?= htmlspecialchars($search_term) ?>">
            <input type="submit" class="input-btn-success" value="Cerca"/>
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
    </div>
</body>
</html>
