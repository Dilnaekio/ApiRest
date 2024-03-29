<?php
require_once "models/ApiManager.php";

class ApiController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new ApiManager;
        $this->apiManager->loadingMonsters();
        $this->apiManager->loadingScores();
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
            throw new Exception("Aucune requête trouvée");
        }
    }

    public function displayMonsters()
    {
        $monsters = $this->apiManager->getMonsters();

        if (!empty($monsters)) {
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
        } else {
            throw new Exception("Aucun monstre stocké en BDD !");
        }
    }

    public function displayMonster($id_monster)
    {
        $monster = $this->apiManager->getMonsterById($id_monster);

        if (empty($monster)) {
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

    public function displayScore($id_user)
    {
        $user = $this->apiManager->getScorerById($id_user);

        if (empty($user)) {
            http_response_code(404);
            $this->displayErrors(404);
        } else {
            $userJson = [];

            $userJson = [
                "name" => $user->getName(),
                "score" => $user->getScore(),
                "created at" => $user->getCreatedAt()
            ];
            $this->sendJson($userJson);
        }
    }

    public function displayAllScores()
    {
        $scores = $this->apiManager->getScores();

        $scoresTab["scoress"] = [];
        foreach ($scores as $score) {

            $scoresTab["scoress"][$score->getId()] = [
                "User" => $score->getName(),
                "Score" => $score->getScore(),
                "Created at" => $score->getCreatedAt()
            ];
        }
        $this->sendJson($scoresTab);
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
            throw new Exception("Aucune requête trouvée !");
        }
    }

    public function deleteScore()
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            header("Access-Controll-Allow-Methods: DELETE");
            if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
                header("Content-Type: application/json; charset=utf-8");
                $body = file_get_contents("php://input");
                $object = json_decode($body, true);

                if (count($object) === 1 && array_keys($object, "name")) {
                    $result = $this->apiManager->findUser($object["name"]);

                    if (!empty($result)) {
                        http_response_code(204);
                        $this->apiManager->deleteScoreDB($result);
                    } else {
                        throw new Exception('Utilisateur non trouvé dans les scores');
                    }
                } else {
                    throw new Exception("Trop d'éléments dans le json. Il ne doit y avoir que 'name'");
                }
            } else {
                http_response_code(405);
                $this->displayErrors(405);
            }
        } else {
            throw new Exception("Aucune requête envoyée");
        }
    }

    public function modifyNameScore()
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            header("Access-Controll-Allow-Methods: PATCH");
            if ($_SERVER["REQUEST_METHOD"] === "PATCH") {
                
                header("Content-Type: application/json; charset=utf-8");
                $body = file_get_contents("php://input");
                $object = json_decode($body, true);

                $result = $this->apiManager->modifyNameScoreDB($object["id"], $object["value"]);
                var_dump($result);
                exit;

                if ($result) {

                    http_response_code(200);
                } else {
                    http_response_code(304);
                    $this->displayErrors(304);
                }
            } else {
                throw new Exception("Mauvaise requête envoyée ! Il n'y a que du patch ici les frérots");
            }
        } else {
            throw new Exception("Aucune requête envoyée");
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
