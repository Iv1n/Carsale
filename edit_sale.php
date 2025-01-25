<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать продажу - Автосалон</title>
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
        .edit-form input[type="text"], .edit-form input[type="submit"] {
            padding: 10px;
            width: calc(100% - 22px);
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .edit-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Редактировать продажу</h1>
    </header>
    <div class="nav">
        <a href="sales.php" class="home-button">Вернуться к списку продаж</a>
    </div>
    <div class="content">
        <h2>Форма редактирования продажи</h2>
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

        // Получение ID записи для редактирования
        $edit_id = $_GET['edit_id'];

        // Получение данных записи для редактирования
        $sql = "SELECT SaleID, ClientID, CarID, Discount, FinalPrice FROM sales WHERE SaleID = $edit_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No record found";
            exit;
        }
        ?>
        <form class="edit-form" method="POST" action="">
            <input type="hidden" name="edit_id" value="<?php echo $row['SaleID']; ?>">
            <input type="text" name="edit_clientid" placeholder="ClientID" value="<?php echo $row['ClientID']; ?>" required>
            <input type="text" name="edit_carid" placeholder="CarID" value="<?php echo $row['CarID']; ?>" required>
            <input type="text" name="edit_discount" placeholder="Discount" value="<?php echo $row['Discount']; ?>" required>
            <input type="text" name="edit_finalprice" placeholder="FinalPrice" value="<?php echo $row['FinalPrice']; ?>" required>
            <input type="submit" name="edit_sale" value="Сохранить">
        </form>
        <?php
        // Обработка редактирования записи
        if (isset($_POST['edit_sale'])) {
            $edit_id = $_POST['edit_id'];
            $edit_clientid = $_POST['edit_clientid'];
            $edit_carid = $_POST['edit_carid'];
            $edit_discount = $_POST['edit_discount'];
            $edit_finalprice = $_POST['edit_finalprice'];
            $sql = "UPDATE sales SET ClientID=$edit_clientid, CarID=$edit_carid, Discount=$edit_discount, FinalPrice=$edit_finalprice WHERE SaleID=$edit_id";
            if ($conn->query($sql) === TRUE) {
                // Перенаправление на страницу sales.php после успешного сохранения
                header("Location: sales.php");
                exit;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
