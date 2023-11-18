<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстратура поліклініки</title>
    <link rel="stylesheet" href="style/reset.css"> 
    <link rel="stylesheet" href="style/register/register_style.css">
    <script src="scripts/day_and_time_of_reception.js"></script>
</head> 
<body> 
    <div class="header">
        <h1>Реєстратура поліклініки</h1>
    </div>
    <div class="navigation">
        <p><a href="index.php">Головна сторінка лікарні</a></p>
        <p><a href="schedule.php">Розклад роботи лікарні</a></p>
        <p><a href="contact.php">Контактна інформація</a></p>
        <p><a href="">Соціальні Послуги</a></p>
        <p><a href="">Соціальні мережі</a></p>
        <p><a href="">Платні послуги</a></p>
    </div>
    <div class="main-block">
        <div class="main-container">
            <div class="main-text">
                <h2>Запис на консультацію</h2> 
                <p>Для запису на прийом з лікарем необхідно зателефонувати в нашу реєстратуру або відвідати нашу поліклініку особисто. Для зручності, ми також надаємо можливість запису на прийом через наш веб-сайт.</p> 
                <div class="contact-container">
                    <div class="contact">
                        <form method="post">
                            <label>ПІБ:</label>
                            <input type="text" name="name" required>
                
                            <label>Телефон:</label>
                            <input type="tel" name="phone" required>
                
                            <label>Email:</label>
                            <input type="email" name="email" required>
                
                            <label>Виберіть лікаря</label>
                            <select type="text" name="doctor" id="doctorSelect" required>
                                <option value="">Виберіть лікаря</option>
                                <option value="doctorSmith">Доктор Сміт</option>
                                <option value="doctorGarcia">Доктор Гарсіа</option>
                                <option value="doctorBrown">Доктор Браун</option>
                            </select>                            
                
                            <label>День прийому:</label>
                            <select type="text" name="appointmentDay" id="appointmentDay" required>
                                <option value="">Виберіть день неділі</option>
                            </select>
                
                            <label>Час прийому:</label>
                            <select name="appointmentTime" id="appointmentTime" required>
                            <option type="submit" value="">Виберіть час відвідування</option>
                            </select>
                
                            <input type="submit" name="formSubmit" value="Відправити">
                        </form>

                        <?php
                            if (isset($_POST['formSubmit'])) {
                                $name = $_POST["name"];
                                $phone = $_POST['phone'];
                                $email = $_POST['email'];
                                $doctor = $_POST['doctor'];
                                $appointmentDay = $_POST['appointmentDay'];
                                $appointmentTime = $_POST['appointmentTime'];
                            
                                // Переконайтеся, що тип поля appointmentTime в базі даних - VARCHAR
                            
                                // Форматуємо рядок часу для зберігання в базі даних
                                list($startHour, $startMinute, $endHour, $endMinute) = sscanf($appointmentTime, "%d:%d-%d:%d");
                                $formattedAppointmentTime = sprintf('%02d:%02d-%02d:%02d', $startHour, $startMinute, $endHour, $endMinute);
                            
                                $mysqli = new mysqli("localhost", "root", "", "hospital_website");
                                if ($mysqli->connect_errno) {
                                    echo "Вибачте, виникла помилка на сайті";
                                    exit;
                                }
                            
                                $name = $mysqli->real_escape_string($name);
                                $phone = $mysqli->real_escape_string($phone);
                                $email = $mysqli->real_escape_string($email);
                                $doctor = $mysqli->real_escape_string($doctor);
                                $appointmentDay = $mysqli->real_escape_string($appointmentDay);
                                $appointmentTime = $mysqli->real_escape_string($formattedAppointmentTime); // Використовуємо відформатований час
                            
                                $query = "INSERT INTO registration (name, phone, email, doctor, appointmentDay, appointmentTime) 
                                        VALUES ('$name', '$phone', '$email', '$doctor', '$appointmentDay', '$appointmentTime')";
                            
                                $result = $mysqli->query($query);
                                if ($result) {
                                    echo 'Реєстрація пройшла успішно!<br>';
                                } else {
                                    echo "Помилка виконання запиту: " . $mysqli->error;
                                }
                            
                                $mysqli->close();
                            }
                            ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="register-tabl">
            <h2>Консультації на цей тиждень</h2> 
            <?php
                $mysqli = new mysqli("localhost", "root", "", "hospital_website");
                if ($mysqli->connect_errno) {
                    echo "Вибачте, виникла помилка на сайті";
                    exit;
                }

                $query = "SELECT name, doctor, appointmentDay, appointmentTime FROM registration";
                $result = $mysqli->query($query);

                if ($result) {
                    echo "<table border='1'>";
                    echo "<tr><th>Ім'я</th><th>Лікар</th><th>День</th><th>Час</th></tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["name"]."</td><td>".$row["doctor"]."</td><td>".$row["appointmentDay"]."</td><td>".$row["appointmentTime"]."</td></tr>";
                    }

                    echo "</table>";
                } else {
                    echo "0 результатів";
                }

                $mysqli->close();
            ?>   
        </div>

    </div>
    <div class="sidebar">
        <div class="contacts">
            <h3>Контакти:</h3>
            <p> 555-1234</p>
            <p>777-4321</p>
        </div>
        <div class="mail">
            <h3>Пошта:</h3>
            <p>info@polyclinick.com</p>
        </div>
        <div class="address">
            <h3>Адреса:</h3>
            <p>м. Херсон</p>
            <p>вул. Поліклініки, 1</p>
        </div>
        <div class="schedule">
            <h3>Розклад роботи:</h3>
            <p>Понеділок-П'ятниця: 8:00 - 20:00</p>
            <p>Субота-Неділя: 10:00 - 16:00</p>
        </div>
    </div>
</body> 
</html>
