<?php
// Configuration générale du cours
define('COURSE_TITLE', 'Laravel 12 : Construire une Application Commerciale de A à Z');
define('COURSE_AUTHOR', 'P. Rahmouni Oussama');
define('COURSE_LAST_UPDATE', 'Novembre 2025');

// Structure du cours pour générer le sommaire dynamiquement
$course_parts = [
    "Partie 1 : Démarrage & Fondamentaux" => [
        ['id' => 'intro-frameworks', 'title' => "Chapitre 1 : Introduction aux Frameworks & Écosystème Laravel"],
        ['id' => 'install-env', 'title' => "Chapitre 2 : Installation & Configuration de l'Environnement"],
        ['id' => 'architecture-lifecycle', 'title' => "Chapitre 3 : Architecture & Cycle de Vie d'une Requête"]
    ],
    "Partie 2 : Modèles, BDD & Eloquent" => [
        ['id' => 'migrations-seeders', 'title' => "Chapitre 4 : Migrations & Seeders"],
        ['id' => 'eloquent-bases', 'title' => "Chapitre 5 : Eloquent – Les Bases"],
        ['id' => 'eloquent-avance', 'title' => "Chapitre 6 : Eloquent – Avancé"]
    ],
    "Partie 3 : Blade, Tailwind & Vite" => [
        ['id' => 'blade-avance', 'title' => "Chapitre 7 : Blade Avancé"],
        ['id' => 'tailwind-laravel', 'title' => "Chapitre 8 : Tailwind dans Laravel"]
    ],
    "Partie 4 : Authentification & Sécurité" => [
        ['id' => 'auth-breeze', 'title' => "Chapitre 9 : Auth avec Laravel Breeze"],
        ['id' => 'roles-permissions', 'title' => "Chapitre 10 : Rôles & Permissions"]
    ],
    "Partie 5 : Internationalisation (i18n)" => [
        ['id' => 'multilingue', 'title' => "Chapitre 11 : Gestion Multilingue"]
    ],
    "Partie 6 : Modules Commerciaux" => [
        ['id' => 'gestion-clients-fournisseurs', 'title' => "Chapitre 12 : Clients & Fournisseurs"],
        ['id' => 'gestion-commandes-factures', 'title' => "Chapitre 13 : Commandes & Facturation"],
        ['id' => 'gestion-stocks', 'title' => "Chapitre 14 : Gestion des Stocks"]
    ],
    "Partie 7 : Services : Mailing & Queues" => [
        ['id' => 'emails', 'title' => "Chapitre 15 : Envoi d'Emails & Notifications"],
        ['id' => 'jobs-queues', 'title' => "Chapitre 16 : Tâches Asynchrones (Queues)"]
    ],
    "Partie 8 : Import/Export & PDF" => [
        ['id' => 'import-export-excel', 'title' => "Chapitre 17 : Import / Export Excel"],
        ['id' => 'generation-pdf', 'title' => "Chapitre 18 : Génération de PDF"]
    ],
    "Partie 9 : Administration & Paramétrage" => [
        ['id' => 'parametrage-global', 'title' => "Chapitre 19 : Paramétrage Global"],
        ['id' => 'audit-logs', 'title' => "Chapitre 20 : Audit & Journalisation"]
    ],
    "Partie 10 : API & Intégrations" => [
        ['id' => 'api-rest', 'title' => "Chapitre 21 : Créer une API REST"],
        ['id' => 'systemes-externes', 'title' => "Chapitre 22 : Intégration de Services Externes"]
    ],
    "Partie 11 : Tests, Déploiement & Optimisation" => [
        ['id' => 'testing', 'title' => "Chapitre 23 : Tests Unitaires & Fonctionnels"],
        ['id' => 'optimisation', 'title' => "Chapitre 24 : Optimisation des Performances"],
        ['id' => 'deploiement', 'title' => "Chapitre 25 : Déploiement en Production"]
    ],
    "Partie 12 : Bonus : Aller plus loin" => [
        ['id' => 'livewire', 'title' => "Chapitre 26 : Livewire 3"],
        ['id' => 'modules-internes', 'title' => "Chapitre 27 : Architecture Modulaire"],
        ['id' => 'architecture-propre', 'title' => "Chapitre 28 : Clean Architecture"]
    ]
];
?>