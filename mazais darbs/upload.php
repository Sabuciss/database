<?php
//Veido reportus jeb izrakstus priekš debugging
ini_set('display_errors', 1); //attēlo kļūdas ja tādas ir lietderīgs priekš debugging
ini_set('display_startup_errors', 1); ////attēlo kļūdas ja tādas ir lietderīgs priekš debugging
error_reporting(E_ALL); ////attēlo kļūdas ja tādas ir lietderīgs priekš debugging

//iekļaujam config failu kas izveido connection ar DB
require_once 'config.php'; //require once palīdz noverst dublikāta kļūdas


$successMessage = ""; //tukšs strings lai attēlu ziņas par upload statusu

//pārbauda vai fails tika augšupieladēts caur mūsu formu
if (isset($_FILES['uploadedFile'])) { 
    $file = $_FILES['uploadedFile']; //saglabā visus datus par attiecīgo faiilu
    $fileName = $file['name']; // saglabā jeb dabū faila nosaukuu
    $fileTmpName = $file['tmp_name']; //saglabā temp failu pirms augšupielādes
    $fileError = $file['error']; //izmet errorus ja tādi ir 0=ka kļudas nav

//norāda folderi kur šis fails tiks saglabāts/uzglabāts
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) { //checko ja upload mape nav izveidota tad izveidojam šo mapi
        mkdir($uploadDir, 0777, true);//777 = read+write+exe
    }

    $filePath = $uploadDir . basename($fileName); //pilnais path kur fails tiks augšupieladēts

    if ($fileError === 0) { //pārbauda kļūdas ja tādas ir prims augšupielādes
        if (move_uploaded_file($fileTmpName, $filePath)) { //ja viss ir safe tad temp failu parceļam uz īsto lokāciju
            $successMessage .= "✅ File successfully uploaded to folder.\n "; //attēlosim ziņojumu ka fails ir aizceļojis uz pareizo folderi

         //saglabājam failus DB
            $sql = "INSERT INTO files (file_name, file_path) VALUES (:fileName, :filePath)";
            $stmt = $conn->prepare($sql); //aizsargāties pret SQL injectionam

            try {
                $stmt->execute([
                    ':fileName' => $fileName, //iepušojam faila detailus iekš DB tabulas
                    ':filePath' => $filePath ////iepušojam faila detailus iekš DB tabulas
                ]);

                if ($stmt->rowCount() > 0) { //pārbauda vai datubāze dati tika ievietoi veiksmīgi
                    $successMessage .= " File path saved in the database successfully! ";
                } else {
                    $successMessage .= " Failed to save file path in the database. "; //ja ir kļudas tad attēlojam
                }
            } catch (PDOException $e) {
                $successMessage .= " Error saving file to the database: " . $e->getMessage() . " ";
            }

        } else {
            $successMessage .= " Failed to upload file! ";
        }
    } else {
        $successMessage .= " Error uploading your file! ";
    }
}


$conn = null; //db connection  aizvēršana lai taupītu mūsu server resursus

//redirecto atpakaļ uz index.html
header("Location: upload.html?successMessage=" . urlencode($successMessage));
exit();
