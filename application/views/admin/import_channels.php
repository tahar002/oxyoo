<!DOCTYPE html>
<html lang="en">
<head>
    

<a href="<?= site_url('all_channels') ?>" class="btn btn-primary">retour tout les chaines </a>

<?php include("partials/footer_rights.php"); ?>
    <meta charset="UTF-8">
    <title>Importation des Chaînes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.11/jquery.csv.min.js"></script>
	
	<?php include("partials/footer_rights.php"); ?>
</head>
<body>
<?php include("partials/footer_rights.php"); ?>
    <h2>Importation des Chaînes</h2>
    <form action="<?= site_url('admin/do_import') ?>" method="post" enctype="multipart/form-data">
        <label for="file">Sélectionnez un ou plusieurs fichiers CSV, XLSX ou XLS :</label><br>
        <input type="file" name="file" id="file" multiple accept=".csv, .xlsx, .xls"><br><br>
        <div id="preview"></div>
        <input type="submit" value="Importer">
    </form>

    <!-- Inclure le contenu de la table des chaînes en PHP -->
    <?php
    // Récupérer les données de la table SQL "live_tv_channels"
    $query = $this->db->get('live_tv_channels');
    $channels = $query->result_array();
    ?>
<?php include("partials/footer_rights.php"); ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>banner</th>
            <th>Type de Flux</th>
            <th>URL</th>
            <th>content_type</th>
            <th>type</th>
            <th>Statut</th>
            <th>featured</th>
            <th>user_agent</th>
            <th>referer</th>
            <th>cookie</th>
            <th>headers</th>
            <th>drm_uuid</th>
            <th>drm_license_uri</th>
            <th>genres</th>
        </tr>
        <?php foreach ($channels as $channel): ?>
            <tr>
                <td><?= $channel['id'] ?></td>
                <td><?= $channel['name'] ?></td>
                <td><?= $channel['banner'] ?></td>
                <td><?= $channel['stream_type'] ?></td>
                <td><?= $channel['url'] ?></td>
                <td><?= $channel['content_type'] ?></td>
                <td><?= $channel['type'] ?></td>
                <td><?= $channel['status'] == 1 ? 'Publié' : 'Non publié' ?></td>
                <td><?= $channel['featured'] ?></td>
                <td><?= $channel['user_agent'] ?></td>
                <td><?= $channel['referer'] ?></td>
                <td><?= $channel['cookie'] ?></td>
                <td><?= $channel['headers'] ?></td>
                <td><?= $channel['drm_uuid'] ?></td>
                <td><?= $channel['drm_license_uri'] ?></td>
                <td><?= $channel['genres'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

 <?php include("partials/footer.php"); ?>


    <script>
        // JavaScript pour gérer l'aperçu des fichiers CSV
        $(document).ready(function(){
            $('#file').change(function(){
                var files = $(this)[0].files;
                $('#preview').empty();
                
                for(var i=0; i<files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = (function(file) {
                        return function(e) {
                            var csv = e.target.result;
                            var data = $.csv.toArrays(csv);
                            var table = '<h3>Aperçu des données de ' + file.name + '</h3>';
                            table += '<table border="1">';
                            for(var row in data){
                                table += '<tr>';
                                for(var item in data[row]){
                                    table += '<td>'+data[row][item]+'</td>';
                                }
                                table += '</tr>';
                            }
                            table += '</table>';
                            $('#preview').append(table);
                        };
                    })(files[i]);
                    reader.readAsText(files[i]);
                }
            });
        });
    </script>
</body>
</html>