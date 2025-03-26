<?php 
//veido reportus jeb ierakstus prieks debugging
ini_set('display_errors', 1); // attēlo kļūdas ja tadas ir 
ini_set('display_startup_errors', 1);
error_reporting(1);

require_once 'config.php';
 
$successMessage = "";

if (isset($_FILES['uploadedFile'])) {  //pārbauda vai tika augšupielādēts fails caur mūsu failu 
    $file = $_FILES['uploadedFile'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];

    $uploadDir = "uploads/"; //kur glabās 

    if (!is_dir($uploadDir)){ //checko ja upload mape nav izveidota 
        mkdir($uploadDir, 0777, true); // 777 read+write+execute
    }
   $filePath = $uploadDir . basename($fileName); //pilnais nosaukums kur saglabas

   if ($filError === 0){  //pārbauda errorus
       if (move_uploaded_file($fileTmpName, $filePath)){ //ja viss save pārceļ uz īsto lokāciju 
        $successMessage .= "File successfully uploaded to folder.\n "; //ziņojums ka viss ir okey

        $sql = "INSERT INTO upload_paths (file_name, file_path) VALUES (:fileName, :filePath";
        $stmt = $conn->prepare($sql); //atļauj izvairīties no sql injections 

        try{
            $stm->execute([
                ':filename' => $fileName, //iepushojam faila details db
                ':filePath' => $filePath

            ]);

            if ($stmt->rowCount() > 0){ //pārbauda vai tikaveiksmīgi ievietots db
                $successMessage .= "File path saved in the db successfully!";
            }
            else{
                $successMessage .= "Failed to save file path in the db"; //ja ir kļūdas attelo tās
            }
         }
         catch(PDOException $e){
            $successMessage .= "Error saving file to the db" . $e->getMessage() . " ";
         }
      }
      else{
        $successMessage .= "Failed to upload file!";
      }
   } else{
    $successMessage .= "Error upload your file!";
  }
}

$conn = null; //db connection aizvēršana lai taupītu mūsu servera resursus

header("Location: index.html?successMessage=" . urlencode($successMessage)); //rederecto uz mūsu index.html
exit();


?>