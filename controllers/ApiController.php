<?php
require_once "models/ApiManager.php";

class ApiController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new ApiManager;
    }

    public function sendJson($data)
    {
        $jsonData = json_encode($data);
        echo $jsonData . "\n";
    }

    public function displayMonsters()
    {
        $monsters = $this->apiManager->getMonsters();
        $this->sendJson($monsters);
    }
}
