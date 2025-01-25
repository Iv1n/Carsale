<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автосалон</title>
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
        .date-time {
            text-align: center;
            margin-bottom: 20px;
        }
        .work-days {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Автосалон</h1>
    </header>
    <div class="nav">
        <a href="cars.php">Автомобили</a>
        <a href="clients.php">Клиенты</a>
        <a href="sales.php">Продажи</a>
    </div>
    <div class="content">
        <div class="date-time">
            <p id="current-date-time"></p>
        </div>
        <div class="work-days">
            <h2>Рабочие и нерабочие дни в этом месяце</h2>
            <p id="work-days"></p>
        </div>
    </div>
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('current-date-time').textContent = now.toLocaleDateString('ru-RU', options);
        }

        function getWorkDays() {
            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const workDays = [];
            const nonWorkDays = [];

            for (let day = 1; day <= daysInMonth; day++) {
                const currentDay = new Date(year, month, day);
                const dayOfWeek = currentDay.getDay();
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    nonWorkDays.push(day);
                } else {
                    workDays.push(day);
                }
            }

            document.getElementById('work-days').innerHTML = `
                <strong>Рабочие дни:</strong> ${workDays.join(', ')}<br>
                <strong>Нерабочие дни:</strong> ${nonWorkDays.join(', ')}
            `;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
        getWorkDays();
    </script>
</body>
</html>
