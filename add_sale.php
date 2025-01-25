<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить продажу - Автосалон</title>
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
        .add-form input[type="text"], .add-form input[type="submit"] {
            padding: 10px;
            width: calc(100% - 22px);
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .add-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .suggestions {
            border: 1px solid #ddd;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            width: calc(100% - 22px);
            z-index: 1;
        }
        .suggestions div {
            padding: 10px;
            cursor: pointer;
        }
        .suggestions div:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="add_clientid"], input[name="add_carid"]').on('focus', function() {
                var inputField = $(this);
                var fieldName = inputField.attr('name');

                $.ajax({
                    url: 'get_suggestions.php',
                    method: 'POST',
                    data: { field: fieldName },
                    success: function(data) {
                        inputField.next('.suggestions').html(data).show();
                    }
                });
            });

            $('input[name="add_clientid"], input[name="add_carid"]').on('input', function() {
                var inputField = $(this);
                var inputValue = inputField.val();
                var fieldName = inputField.attr('name');

                if (inputValue.length >= 1) {
                    $.ajax({
                        url: 'get_suggestions.php',
                        method: 'POST',
                        data: { field: fieldName, query: inputValue },
                        success: function(data) {
                            inputField.next('.suggestions').html(data).show();
                        }
                    });
                } else {
                    inputField.next('.suggestions').hide();
                }
            });

            $(document).on('click', '.suggestions div', function() {
                var selectedValue = $(this).data('id');
                var inputField = $(this).parent().prev('input');
                inputField.val(selectedValue);
                inputField.next('.suggestions').hide();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.suggestions').length && !$(e.target).is('input[name="add_clientid"], input[name="add_carid"]')) {
                    $('.suggestions').hide();
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Добавить продажу</h1>
    </header>
    <div class="nav">
        <a href="sales.php" class="home-button">Вернуться к списку продаж</a>
    </div>
    <div class="content">
        <h2>Форма добавления продажи</h2>
        <form class="add-form" method="POST" action="">
            <div style="position: relative;">
                <input type="text" name="add_clientid" placeholder="ClientID" required>
                <div class="suggestions" style="display:none;"></div>
            </div>
            <div style="position: relative;">
                <input type="text" name="add_carid" placeholder="CarID" required>
                <div class="suggestions" style="display:none;"></div>
            </div>
            <input type="text" name="add_discount" placeholder="Discount" required>
            <input type="text" name="add_finalprice" placeholder="FinalPrice" required>
            <input type="submit" name="add_sale" value="Добавить">
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
        if (isset($_POST['add_sale'])) {
            $add_clientid = $_POST['add_clientid'];
            $add_carid = $_POST['add_carid'];
            $add_discount = $_POST['add_discount'];
            $add_finalprice = $_POST['add_finalprice'];
            $sql = "INSERT INTO sales (ClientID, CarID, Discount, FinalPrice) VALUES ($add_clientid, $add_carid, $add_discount, $add_finalprice)";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
