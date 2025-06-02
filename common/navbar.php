<!-- navbar.php -->
<style>
    .navbar {
        background-color: #333;
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar h1 {
        margin: 0;
        color: white; 
        font-size: 20px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
    }

    .navbar a:hover {
        text-decoration: underline;
    }

    .nav-links {
        display: flex;
        align-items: center;
    }
</style>

<div class="navbar">
    <h1>Biblioteca</h1>
    <div class="nav-links">
        <a href="/pages/loan/index.php">Prestiti Attivi</a>
        <a href="/pages/history/index.php">Storico Prestiti</a>
        <a href="/pages/book-author/index.php">Libri autori</a>
        <a href="/pages/author/index.php">Autori</a>
        <a href="/pages/reports/index.php">Report</a>
    </div>
</div>
