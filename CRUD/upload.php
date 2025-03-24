<?php
$servername = "localhost";
$username = "root";  
$password = "root";     
$dbname = "crud_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the upload directory
$uploadDir = 'uploads/'; // Specify the folder where files will be stored

// Check if the upload directory exists, create it if not
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Creates the directory if it doesn't exist
}

// Check if the file was uploaded
if (isset($_FILES['fileUpload'])) {
    $fileName = $_FILES['fileUpload']['name'];
    $fileTmpName = $_FILES['fileUpload']['tmp_name'];
    $fileSize = $_FILES['fileUpload']['size'];
    $fileError = $_FILES['fileUpload']['error'];

    // Check for upload errors
    if ($fileError === UPLOAD_ERR_OK) {
        // Generate a unique name for the file to avoid conflicts
        $uniqueFileName = time() . '_' . $fileName;

        // Define the path where the file will be saved
        $filePath = $uploadDir . $uniqueFileName;

        // Try to move the uploaded file
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Save the file path to the database
            $sql = "INSERT INTO uploaded_files (file_name, file_path) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $fileName, $filePath);

            if ($stmt->execute()) {
                echo "File uploaded successfully. File path: " . $filePath;
            } else {
                echo "Error saving file path to database.";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Error uploading file. Code: " . $fileError;
    }
}

$conn->close();
?>
