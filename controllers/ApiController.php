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
        $jsonData = json_encode($data);
        echo $jsonData;
    }

    public function displayMonsters()
    {
        $monsters = $this->apiManager->getMonsters();

        $monsterTab["monsters"] = [];
        foreach ($monsters as $monster) {

            $monstersTab["monsters"][$monster->getId()][] = [

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
