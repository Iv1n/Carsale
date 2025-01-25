<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Продажи - Автосалон</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #a3e3dc;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: center;
            background-color: #333;
        }
        .nav a {
            text-decoration: none;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .nav a:hover {
            background-color: #555;
        }
        .content {
            padding: 20px;
            background-color: white;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
        }
        .home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f4;
        }
        .add-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .edit-button {
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button:hover {
            background-color: #ef6c00;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Продажи</h1>
    </header>
    <div class="nav">
        <a href="index.php" class="home-button">Вернуться на главную страницу</a>
    </div>
    <div class="content">
        <h2>Список продаж</h2>
        <a href="add_sale.php" class="add-button">Добавить продажу</a>
        <form class="search-form" method="GET" action="">
            <br>
            <input type="text" name="client_id" placeholder="ID Клиента">
            <input type="text" name="car_id" placeholder="ID Автомобиля">
            <input type="submit" value="Поиск">
        </form>
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

        // Обработка удаления записи
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM sales WHERE SaleID = $delete_id";
            if ($conn->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    

        // Получение параметров поиска
        $client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
        $car_id = isset($_GET['car_id']) ? $_GET['car_id'] : '';

        // Формирование SQL-запроса в зависимости от параметров поиска
        $sql = "SELECT SaleID, ClientID, CarID, Discount, FinalPrice FROM sales";
        $conditions = [];
        if (!empty($client_id)) {
            $conditions[] = "ClientID = '$client_id'";
        }
        if (!empty($car_id)) {
            $conditions[] = "CarID = '$car_id'";
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод данных в виде таблицы
            echo "<table>";
            echo "<tr><th>ID</th><th>ID Клиента</th><th>ID Автомобиля</th><th>Скидка</th><th>Итоговая Цена</th><th>Действия</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["SaleID"] . "</td>";
                echo "<td>" . $row["ClientID"] . "</td>";
                echo "<td>" . $row["CarID"] . "</td>";
                echo "<td>" . $row["Discount"] . "</td>";
                echo "<td>" . $row["FinalPrice"] . "</td>";
                echo "<td>";
                echo "<a href='edit_sale.php?edit_id=" . $row["SaleID"] . "' class='edit-button'>Редактировать</a>";
                echo "<a href='?delete_id=" . $row["SaleID"] . "' class='delete-button'>Удалить</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
