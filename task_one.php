<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Форма для отправки данных</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }

        .success-message {
            color: green;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="form-container">
    <form id="myForm" onsubmit="return submitForm()">
        <div class="form-group">
            <label for="firstName">Имя:</label>
            <input type="text" id="firstName" name="firstName" required>
        </div>

        <div class="form-group">
            <label for="lastName">Фамилия:</label>
            <input type="text" id="lastName" name="lastName" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <span class="error-message" id="emailError"></span>
        </div>

        <div class="form-group">
            <label for="phone">Номер телефона:</label>
            <input type="tel" id="phone" name="phone" required>
            <span class="error-message" id="phoneError"></span>
        </div>

        <button type="submit">Отправить</button>
    </form>
    <div class="success-message" id="successMessage"></div>
</div>

<script>
    function submitForm() {
        // Валидация e-mail
        var emailInput = document.getElementById("email");
        var emailError = document.getElementById("emailError");
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            emailError.textContent = "Введите корректный e-mail адрес";
            return false;
        } else {
            emailError.textContent = "";
        }

        // Валидация номера телефона
        var phoneInput = document.getElementById("phone");
        var phoneError = document.getElementById("phoneError");
        var phonePattern = /^\+7\d{10}$/;
        if (!phonePattern.test(phoneInput.value)) {
            phoneError.textContent = "Введите номер телефона в формате +7XXXXXXXXXX";
            return false;
        } else {
            phoneError.textContent = "";
        }

        // Отправка данных формы (в данном примере выводим сообщение об успешной отправке)
        var successMessage = document.getElementById("successMessage");
        successMessage.textContent = "Данные успешно отправлены!";
        successMessage.style.display = "block";

        // Предотвращаем отправку формы, чтобы пользователь не покидал страницу
        return false;
    }
</script>
</body>
</html>
