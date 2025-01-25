<?php
// Данные для подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "root"; // Замените 'your_password' на ваш реальный пароль
$dbname = "carshowroom";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из запроса
$field = $_POST['field'];
$query = isset($_POST['query']) ? $_POST['query'] : '';

// Обработка запроса для ClientID
if ($field == 'add_clientid') {
    $sql = "SELECT ClientID, LastName FROM clients WHERE LastName LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div data-id='" . $row["ClientID"] . "'>" . $row["LastName"] . " (" . $row["ClientID"] . ")</div>";
        }
    } else {
        echo "<div>No results found</div>";
    }
}

// Обработка запроса для CarID
if ($field == 'add_carid') {
    $sql = "SELECT CarID, CarBrand FROM cars WHERE CarBrand LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div data-id='" . $row["CarID"] . "'>" . $row["CarBrand"] . " (" . $row["CarID"] . ")</div>";
        }
    } else {
        echo "<div>No results found</div>";
    }
}

$conn->close();
?>
