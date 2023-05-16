<?php
    if (isset($_POST['references'])) {
        $selectedReferences = $_POST['references'];

        // Parcours des références sélectionnées
        foreach ($selectedReferences as $selectedKey) {
            echo 'La référence avec la clé ' . $selectedKey . ' est sélectionnée.<br>';
            // Faites ce que vous souhaitez avec chaque $selectedKey
        }
    } else {
        echo 'Aucunes références sélectionées';
    }

?>
