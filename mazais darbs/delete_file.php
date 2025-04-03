<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

//checko vai failam ir nodrošināts id
if(isset($_POST['fileId'])){ //aizsūta pieprasījumu uz db ar posta palīdzību lai iegūtu faila id
    $fileId = $_POST['fileId']; //saglabā field id vērtību kuru vēlāk izmantos laoi nodrošinātu delete funkciju
   
    try{
        //iegūstam faila path no db
        $stmt = $conn->prepare("SELECT file_path FROM files WHERE id = :id" ); //sagatavojam sql querry lai atrastu iekš upload path id
        $stmt->execute([':id' => $fileId]); //excetujam pašu querry attiecīgo id
        $file = $stmt->fetch(PDO::FETCH_ASSOC); //iegūstam visus ierakstus masīva veidā,palīdz veidot delete loģiku

        if($file){ //parbauda vai fails vispār pastāv
            $filePath = $file['file_path']; //iegūstam faila ceļu no db
            
            //deleting file no mūsu upload foldera
            if (file_exists($filePath)){//checkojam vai fails vispār pastāv mūsu upload folderī
                unlink($filePath); //failu izdzēšam no mūsu servera ak foldera
            }

            //izdzēšam faila ierakstu no db 
            $stmt = $conn->prepare("DELETE FROM files WHERE id = :id"); //sagatavojam sql querry lai izdzestu attiecīgo failu no db
            $stmt->execute([':id' => $fileId]);//excecutojam mūsu querry

            if ($stmt->rowCount() > 0){
                echo " File deleted succesfully!";
            } else {
                echo " Failed to delete file from the db";
            }
        } else {
            echo " File not found!";
        }
    } catch (PDOException $e){
        echo " Error deleting file: " . $e->getMessage();
    }
} else {
    echo "No file ID provided";
}

$conn = null;

?>