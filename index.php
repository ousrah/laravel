<?php
/**
 * ===================================================================
 * PAGE PRINCIPALE DU COURS DE GESTION DES DONNÉES II AVEC MYSQL
 * ===================================================================
 * 
 * Rôle de ce fichier :
 * Ce script agit comme un assembleur. Il ne contient aucun HTML direct,
 * mais inclut les différents composants de la page dans un ordre précis
 * pour former le document final.
 * 
 * Ordre d'inclusion :
 * 1. config.php     : Charge la configuration et la structure du sommaire.
 * 2. header.php     : Affiche le haut de la page, incluant le sommaire dynamique.
 * 3. partie_X.php   : Affiche le contenu principal du cours, section par section.
 * 4. footer.php     : Affiche le bas de la page, les scripts et ferme le document.
 * 
 */

// 1. Inclure la configuration et la structure du cours
// Ce fichier est crucial car il est utilisé par le header pour générer le sommaire.
require_once 'config.php';

// 2. Inclure l'en-tête de la page (qui contient le <head>, les styles, et le sommaire)
require_once './layout/header.php';

// 3. Inclure le contenu de chaque partie du cours, dans l'ordre d'affichage souhaité
require_once './partials/partie_1.php'; // Fondamentaux du SQL Procédural
require_once './partials/partie_2.php'; // Logique Applicative Côté Serveur
require_once './partials/partie_3.php'; // Robustesse et Intégrité des Données
require_once './partials/partie_4.php'; // Manipulation Avancée des Données
require_once './partials/partie_5.php'; // Administration et Sécurité
require_once './partials/partie_6.php'; // Ateliers Pratiques et Synthèse
require_once './partials/felicitations.php'; // Ateliers Pratiques et Synthèse

// 4. Inclure le pied de page (qui contient les infos de contact, les scripts JS, et ferme la page)
require_once './layout/footer.php';

?>