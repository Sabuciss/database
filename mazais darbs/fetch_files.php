<?php 
require_once 'config.php';

// Atļautie failu tipi
$imageTypes = ['jpg', 'jpeg', 'png', 'gif'];
$pdfTypes = ['pdf'];
$videoTypes = ['mp4', 'webm'];
$wordTypes = ['doc', 'docx'];
$excelTypes = ['xls', 'xlsx'];
$pptTypes = ['ppt', 'pptx'];
$audioTypes = ['mp3'];

// Apvienojam visus atļautos failu tipus
$allowedTypes = array_merge($imageTypes, $pdfTypes, $videoTypes, $wordTypes, $excelTypes, $pptTypes, $audioTypes);

// Iegūstam visus failus no datubāzes
try {
    $stmt = $conn->query("SELECT * FROM files");
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($files) { 
        foreach ($files as $file) {
            $filePath = $file['file_path'];
            $fileName = $file['file_name'];
            $fileId = $file['id'];
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            echo "<div class='file-card' id='file-{$fileId}'>";

            // ✅ Faila priekšskatījums atkarībā no faila veida
            if (in_array($fileExtension, $imageTypes)) {
                echo "<img src='{$filePath}' alt='{$fileName}' class='thumbnail' width='200'><br>";
            } elseif (in_array($fileExtension, $pdfTypes)) {
                echo "<embed src='{$filePath}' type='application/pdf' width='200' height='200' />";
            } elseif (in_array($fileExtension, $videoTypes)) {
                echo "<video width='200' controls><source src='{$filePath}' type='video/mp4'>Your browser does not support video.</video>";
            } elseif (in_array($fileExtension, $wordTypes)) {
                echo "<div>📄 {$fileName}</div>";
            } elseif (in_array($fileExtension, $excelTypes)) {
                echo "<div>📊 {$fileName}</div>";
            } elseif (in_array($fileExtension, $pptTypes)) {
                echo "<div>📊 {$fileName}</div>";
            } elseif (in_array($fileExtension, $audioTypes)) {
                echo "<audio controls><source src='{$filePath}' type='audio/mp3'>Your browser does not support audio.</audio>";
            } else {
                // Ja fails ir nezināms vai nav atļauts priekšskatīšanai, pievieno linku
                echo "<div>📃 {$fileName}</div>";
            }

            
            // Lejupielādes pogu saglabājam tikai vienu
            echo "<a href='{$filePath}' download><button class='download-button'>Download</button></a>";

            echo "<button class='delete-button' onclick='deleteFile({$fileId})'>Delete</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No files uploaded yet.</p>";
    }
} catch (PDOException $e) {
    echo "<p>❌ Error fetching files: " . $e->getMessage() . "</p>";
}

$conn = null;
?> 
