<?php
require_once "controllers/ApiController.php";
session_start();
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

$apiController = new ApiController;

try {
    if (isset($_GET['page'])) {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        var_dump($url);
    }
    // si GET page est vide on redirige vers l'accueil
    if (empty($url[0])) {
    } else {
        //switch de GET page pour savoir vers quelle page renvoyer l'utilisateur
        switch ($url[0]) {
            case "Monsters":
                $apiController->displayMonsters();
                if (empty($url[1])) {
                    // TODO : méthode pour montrer tous les monstres ?
                } else {
                    // TODO : afficher ici le monstre via l'id stockée dans $url[1]
                }
                break;
            case "Scores":
                // TODO : rajouter une condition pour $url[1] via l'id du score
                if (empty($url[1])) {
                    // TODO : méthode pour montrer tous les scores
                } else {
                    // TODO : afficher ici le score lié à l'id stockée dans $url[1]
                }
                break;
            case "Add":

                break;
            default:
                throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {

    echo $e->getMessage();
}
