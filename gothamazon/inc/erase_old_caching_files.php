<?php function gtz_supprimer_fichiers_trop_anciens($dossier) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dossier, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    
    $time_now = time();
    $one_year = 365 * 24 * 60 * 60; // Un an en secondes

    foreach ($files as $fileinfo) {
        if ($time_now - $fileinfo->getMTime() >= $one_year && !$fileinfo->isDir()) {
            unlink($fileinfo->getRealPath()); // Supprimer seulement le fichier
        }
    }
}

// Ajouter l'intervalle de planification personnalisé à WP-Cron
add_filter('cron_schedules', function ($schedules) {
    // Nom unique pour l'intervalle personnalisé pour éviter les conflits
    if (!isset($schedules['gtz_monthly'])) {
        $schedules['gtz_monthly'] = [
            'interval' => 30 * DAY_IN_SECONDS,
            'display' => __('Once Monthly by GTZ')
        ];
    }
    return $schedules;
});

// Planifier la tâche CRON si elle n'est pas déjà planifiée
if (!wp_next_scheduled('gtz_suppression_mensuelle_fichiers')) {
    wp_schedule_event(time(), 'gtz_monthly', 'gtz_suppression_mensuelle_fichiers');
}

// Attacher la fonction à notre hook personnalisé pour les deux dossiers
add_action('gtz_suppression_mensuelle_fichiers', function () {
    $upload_dir = wp_get_upload_dir();

    // Dossier gtz_t4
    $kapsule_dirstokage_pics_t4 = $upload_dir["basedir"] . '/gtz_t4';
    if (is_dir($kapsule_dirstokage_pics_t4)) {
       gtz_supprimer_fichiers_trop_anciens($kapsule_dirstokage_pics_t4);
    }

    // Dossier gtz_store et ses sous-dossiers
    $kapsule_dirstokage_pics_store = $upload_dir["basedir"] . '/gtz_store';
    if (is_dir($kapsule_dirstokage_pics_store)) {
        gtz_supprimer_fichiers_trop_anciens($kapsule_dirstokage_pics_store);
    }
});

