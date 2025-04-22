<?php
$dir = "fichiers/";
$fichiers = scandir($dir);

echo "<style>body{font-family:Arial;padding:30px;}a{display:block;margin:5px 0;}</style>";
echo "<h3>📂 Fichiers disponibles :</h3><ul>";
foreach ($fichiers as $fichier) {
    if ($fichier !== "." && $fichier !== "..") {
        echo "<li><a href='fichiers/$fichier' download>$fichier</a></li>";
    }
}
echo "</ul>";
echo "<a href='zip.php' style='display:inline-block;margin-top:20px;background:#007BFF;padding:10px;color:white;text-decoration:none;border-radius:5px;'>📦 Télécharger tout en ZIP</a>";
?>

