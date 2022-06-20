<?php
require_once "controllers/ApiController.php";
session_start();
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

$apiController = new ApiController;

try {
    if (isset($_GET['page'])) {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
    }
    // si GET page est vide on redirige vers l'accueil
    if (empty($url[0])) {
    } else {
        //switch de GET page pour savoir vers quelle page renvoyer l'utilisateur
        switch ($url[0]) {
            case "monsters":
                if (empty($url[1])) {
                    var_dump($_SERVER["REQUEST_METHOD"]);
                    $apiController->displayMonsters();
                } else {
                    $apiController->displayMonster($url[1]);
                }
                break;
            case "scores":
                if (empty($url[1])) {
                    $apiController->displayAllScores();
                } else {
                    $apiController->displayScore($url[1]);
                }
                break;
            case "add":
                $apiController->addScore();
                break;
            case "delete":
                $apiController->deleteScore();
                break;
            case "modify":
                $apiController->modifyNameScore();
                break;
            default:
                throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    $apiController->displayErrors(404);
}
