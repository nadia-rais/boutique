<?php
session_start();


?>

<?php
$connect = mysqli_connect('localhost','root','','boutique');

$profiledefault = ("https://i.ibb.co/mG6M0f5/empty-profile-picture.jpg"); //variable pour insérer une photo de profil par défaut à l'inscription


// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" . $_FILES["photo"]["name"])){
                echo $_FILES["photo"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $_FILES["photo"]["name"]);
                echo "Votre fichier a été téléchargé avec succès.";

                $file_path="uploads/" . $_FILES["photo"]["name"];

                //récupérer le chemin du serveur soit avec une super globale SERVER ou le taper en dur


               // "UPDATE utilisateurs SET avatar='$file_path'"; //ajouter id utilisateur

                $requestimg = "UPDATE `image` SET `chemin`='$file_path' WHERE id_article = '$_SESSION[login]'";
                $resultimg = mysqli_query($connect, $requestimg);

        //        header("location:admin_articles.php");

            }
        } else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}



?>
