<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $allowedMimeTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];
    $allowedExtension = ['jpg','jpeg','png'];

    $fileName = basename($_FILES['fileToUpload']['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Buat nama file base64
    $base64FileName = base64_encode($fileName) . '.' . $fileExtension;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['fileToUpload']['tmp_name']);
    finfo_close($finfo);

    $uploadFile = $uploadDir . $base64FileName;

    if (!in_array($mimeType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtension)) {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
    } else {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
            echo "File has been uploaded successfully with filename: " . htmlspecialchars($base64FileName);
        } else {
            echo "Failed to upload file.";
        }
    }
}
?>
