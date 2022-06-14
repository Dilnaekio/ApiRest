<?php
require_once "models/ApiManager.php";

class ApiController
{
    private $apiManager;
    private $allowedMethods = [
        "GET"
    ];

    public function __construct()
    {
        $this->apiManager = new ApiManager;
        $this->apiManager->loadingMonsters();
    }

    public function sendJson($data)
    {
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);

        if (in_array($requestMethod, $this->allowedMethods)) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($data);
        } else {
            http_response_code(405);
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
}
