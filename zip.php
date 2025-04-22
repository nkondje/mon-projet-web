<?php
$zip = new ZipArchive();
$filename = "documents_envoyes.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("Impossible d’ouvrir le fichier ZIP");
}

$dir = 'fichiers/';
$files = scandir($dir);

foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $zip->addFile($dir . $file, $file);
    }
}
$zip->close();

header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename=$filename");
header('Content-Length: ' . filesize($filename));
readfile($filename);
unlink($filename);
exit;
?>
