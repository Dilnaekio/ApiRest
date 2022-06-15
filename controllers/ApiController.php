<?php
require_once "models/ApiManager.php";

class ApiController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new ApiManager;
        $this->apiManager->loadingMonsters();
    }

    public function sendJson($data)
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            header("Access-Control-Allow-Methods: GET");
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                header("Content-Type: application/json; charset=utf-8");
                http_response_code(200);
                echo json_encode($data);
            } else {
                http_response_code(405);
                $this->displayErrors(405);
            }
        } else {
            http_response_code(405);
            $this->displayErrors(405);
        }
    }

    public function displayMonsters()
    {
        $monsters = $this->apiManager->getMonsters();

        $monsterTab["monsters"] = [];
        foreach ($monsters as $monster) {

            $monstersTab["monsters"][$monster->getId()] = [
                "monsters_id" => $monster->getId(),
                "name" => $monster->getName(),
                "atk" => $monster->getAtk(),
                "def" => $monster->getDef(),
                "img" => $monster->getImg(),
                "score" => $monster->getScore(),
                "role" => $monster->getRole()
            ];
        }

        $this->sendJson($monstersTab);
    }

    public function displayMonster($id_monster)
    {
        $monster = $this->apiManager->getMonsterById($id_monster);

        if (empty($monster) or $monster === null) {
            // Je ne sais pas du tout si j'ai utilisé le bon code http ha ha
            http_response_code(404);
            $this->displayErrors(404);
        } else {
            $monsterJson = [];

            $monsterJson = [
                "monsters_id" => $monster->getId(),
                "name" => $monster->getName(),
                "atk" => $monster->getAtk(),
                "def" => $monster->getDef(),
                "img" => $monster->getImg(),
                "score" => $monster->getScore(),
                "role" => $monster->getRole()
            ];
            $this->sendJson($monsterJson);
        }
    }

    public function addScore()
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            header("Access-Control-Allow-Methods: POST");
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                header("Content-Type: application/json; charset=utf-8");
                $body = file_get_contents("php://input");
                $object = json_decode($body, true);

                $this->apiManager->addScoreDB($object["name"], $object["score"]);
            } else {
                http_response_code(405);
                $this->displayErrors(405);
            }
        } else {
            http_response_code(405);
            $this->displayErrors(405);
        }
    }

    public function displayErrors($code)
    {
        header("Content-Type: application/json; charset=utf-8");
        switch ($code) {
            case 203:
                echo json_encode(["message" => "	Information retournée, mais générée par une source non certifiée."]);
                break;
            case 204:
                echo json_encode(["message" => "Aucun contenu"]);
                break;
            case 205:
                echo json_encode(["message" => "Contenu réinitialisé"]);
                break;
            case 206:
                echo json_encode(["message" => "Contenu partiel"]);
                break;
            case 304:
                echo json_encode(["message" => "Non modifié"]);
                break;
            case 305:
                echo json_encode(["message" => "Utilise un proxy"]);
                break;
            case 400:
                echo json_encode(["message" => "Mauvaise requête"]);
                break;
            case 401:
                echo json_encode(["message" => "Non autorisé"]);
                break;
            case 402:
                echo json_encode(["message" => "Paiement requis"]);
                break;
            case 404:
                echo json_encode(["message" => "La page ou le contenu est introuvable :'( :'( :'("]);
                break;
            case 405:
                echo json_encode(["message" => "La requête n'est pas autorisée"]);
                break;

                // J'aurai pu ajouter encore plus de codes d'erreurs mais la flemme
                // https://www.php.net/manual/fr/function.http-response-code.php
                // https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
        }
    }
}
