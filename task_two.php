<?php

class FileUploader
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function uploadFile($file)
    {
        $uploadFilePath = $this->uploadDir . basename($file['name']);

        // Проверка наличия ошибок при загрузке файла
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки файла.');
        }

        // Проверка типа файла, например, разрешаем только изображения jpeg, png, gif
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Недопустимый тип файла.');
        }

        // Перемещаем файл из временной папки в указанную директорию
        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            throw new Exception('Не удалось сохранить файл на сервере.');
        }

        return $uploadFilePath;
    }

    public function getUploadedFiles()
    {
        $uploadedFiles = [];
        $files = glob($this->uploadDir . '*');
        foreach ($files as $file) {
            $uploadedFiles[] = basename($file);
        }
        return $uploadedFiles;
    }

    public function deleteFile($filename)
    {
        $filePath = $this->uploadDir . $filename;
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }
        return false;
    }
}

// Использование класса в демонстрационном скрипте

$uploadDir = 'uploads/'; // Директория, куда будут загружаться файлы

try {
    $uploader = new FileUploader($uploadDir);

    // Загрузка файла на сервер
    if (isset($_FILES['file'])) {
        $uploadedFile = $uploader->uploadFile($_FILES['file']);
        echo "Файл успешно загружен: $uploadedFile<br>";
    }

    // Вывод списка загруженных файлов
    $uploadedFiles = $uploader->getUploadedFiles();
    echo "Список загруженных файлов:<br>";
    foreach ($uploadedFiles as $filename) {
        echo "<a href=\"uploads/$filename\">$filename</a> ";
        echo "<a href=\"?delete=$filename\">(удалить)</a><br>";
    }

    // Удаление выбранного файла
    if (isset($_GET['delete'])) {
        $filenameToDelete = $_GET['delete'];
        if ($uploader->deleteFile($filenameToDelete)) {
            echo "Файл '$filenameToDelete' успешно удален.<br>";
        } else {
            echo "Не удалось удалить файл '$filenameToDelete'.<br>";
        }
    }
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Загрузка файлов</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Загрузить">
</form>
</body>
</html>
