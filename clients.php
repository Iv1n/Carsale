<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клиенты - Автосалон</title>
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
        .search-form, .add-form, .edit-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"], .add-form input[type="text"], .edit-form input[type="text"] {
            padding: 10px;
            width: calc(100% - 22px);
            box-sizing: border-box;
        }
        .search-form input[type="submit"], .add-form input[type="submit"], .edit-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-form input[type="submit"]:hover, .add-form input[type="submit"]:hover, .edit-form input[type="submit"]:hover {
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
        /* Модальное окно */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Клиенты</h1>
    </header>
    <div class="nav">
        <a href="index.php" class="home-button">Вернуться на главную страницу</a>
    </div>
    <div class="content">
        <h2>Список клиентов</h2>
        <form class="search-form" method="GET" action="">
            <input type="text" name="search_lastname" placeholder="Поиск по фамилии">
            <input type="submit" value="Поиск">
        </form>
        <form class="search-form" method="GET" action="">
            <input type="text" name="search_id" placeholder="Поиск по ID">
            <input type="submit" value="Поиск">
        </form>
        <form class="add-form" method="POST" action="">
            <input type="text" name="add_lastname" placeholder="Фамилия" required>
            <input type="text" name="add_passport" placeholder="Номер паспорта" required>
            <input type="submit" name="add_client" value="Добавить">
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

        // Обработка добавления записи
        if (isset($_POST['add_client'])) {
            $add_lastname = $_POST['add_lastname'];
            $add_passport = $_POST['add_passport'];
            $sql = "INSERT INTO clients (LastName, PassportNumber) VALUES ('$add_lastname', '$add_passport')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Обработка удаления записи
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM clients WHERE ClientID = $delete_id";
            if ($conn->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

        // Обработка редактирования записи
        if (isset($_POST['edit_client'])) {
            $edit_id = $_POST['edit_id'];
            $edit_lastname = $_POST['edit_lastname'];
            $edit_passport = $_POST['edit_passport'];
            $sql = "UPDATE clients SET LastName='$edit_lastname', PassportNumber='$edit_passport' WHERE ClientID=$edit_id";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        // Обработка поиска по фамилии
        if (isset($_GET['search_lastname']) && !empty($_GET['search_lastname'])) {
            $search_lastname = $_GET['search_lastname'];
            $sql = "SELECT ClientID, LastName, PassportNumber FROM clients WHERE LastName LIKE '%$search_lastname%'";
        }
        // Обработка поиска по ID
        elseif (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
            $search_id = $_GET['search_id'];
            $sql = "SELECT ClientID, LastName, PassportNumber FROM clients WHERE ClientID = $search_id";
        }
        // Если нет поисковых запросов, выводим все данные
        else {
            $sql = "SELECT ClientID, LastName, PassportNumber FROM clients";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод данных в виде таблицы
            echo "<table>";
            echo "<tr><th>ID</th><th>Фамилия</th><th>Номер паспорта</th><th>Действия</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ClientID"] . "</td>";
                echo "<td>" . $row["LastName"] . "</td>";
                echo "<td>" . $row["PassportNumber"] . "</td>";
                echo "<td>";
                echo "<button class='edit-button' onclick='openModal(" . $row["ClientID"] . ", \"" . $row["LastName"] . "\", \"" . $row["PassportNumber"] . "\")'>Редактировать</button>";
                echo "<a href='?delete_id=" . $row["ClientID"] . "' class='delete-button'>Удалить</a>";
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

    <!-- Модальное окно -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">Редактировать</div>
            <form class="edit-form" method="POST" action="">
                <input type="hidden" id="edit_id" name="edit_id">
                <input type="text" id="edit_lastname" name="edit_lastname" placeholder="Фамилия" required>
                <input type="text" id="edit_passport" name="edit_passport" placeholder="Номер паспорта" required>
                <input type="submit" name="edit_client" value="Сохранить">
            </form>
        </div>
    </div>

    <script>
        // Функция для открытия модального окна
        function openModal(id, lastname, passport) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_lastname').value = lastname;
            document.getElementById('edit_passport').value = passport;
            document.getElementById('editModal').style.display = "block";
        }

        // Функция для закрытия модального окна
        var modal = document.getElementById('editModal');
        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
