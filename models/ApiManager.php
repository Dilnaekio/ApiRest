<?php
require_once "models/Model.php";
require_once "models/MonsterModel.php";

class ApiManager extends Model
{
    private $monsters;

    public function addMonster($monster)
    {
        $this->monsters[] = $monster;
    }

    public function getMonsters()
    {
        return $this->monsters;
    }

    public function loadingMonsters()
    {
        $sql = "SELECT * from monsters";
        $req = $this->getDB()->prepare($sql);
        $req->execute();

        $monsters = $req->fetchAll(PDO::FETCH_OBJ);

        foreach ($monsters as $monster) {
            $add = new Monster($monster->id, $monster->name, $monster->life, $monster->atk, $monster->def, $monster->img, $monster->score, $monster->role);
            $this->addMonster($add);
        }
    }

    public function getMonsterById($id)
    {
        foreach ($this->monsters as $monster) {
            if ($monster->getId() == $id) {
                $result = $monster;
            }
        }
        return $result;
    }

    public function addScoreDB($name, $score)
    {
        $sql = "INSERT INTO high_score (name, score) VALUES (:name, :score)";

        $req = $this->getDB()->prepare($sql);
        return $req->execute([
            ":name" => $name,
            ":score" => $score
        ]);
    }
}
