<?php
// Chemin vers le script Python
$pythonScript = 'admin/converteurm3u.py';
 
// Exécution du script Python
$output = shell_exec('python ' . $pythonScript);
 
// Affichage du résultat
echo $output;
?>
