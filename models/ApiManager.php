<?php
require_once "models/Model.php";
require_once "models/MonsterModel.php";
require_once "models/ScoreModel.php";

class ApiManager extends Model
{
    private $monsters;
    private $scores;

    public function addMonster($monster)
    {
        $this->monsters[] = $monster;
    }

    public function addScore($score)
    {
        $this->scores[] = $score;
    }

    public function getMonsters()
    {
        return $this->monsters;
    }

    public function getScores()
    {
        return $this->scores;
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

    public function loadingScores()
    {
        $sql = "SELECT * from high_score";
        $req = $this->getDB()->prepare($sql);
        $req->execute();

        $scores = $req->fetchAll(PDO::FETCH_OBJ);

        foreach ($scores as $score) {
            $add = new Score($score->id, $score->name, $score->score, $score->created_at);
            $this->addScore($add);
        }

        return $req->fetchAll(PDO::FETCH_OBJ);
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

    public function getScorerById($id)
    {
        foreach ($this->scores as $score) {
            if ($score->getId() == $id) {
                $result = $score;
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

    public function deleteScoreDB($id)
    {
        $sql = "DELETE from high_score WHERE id = :id";

        $req = $this->getDB()->prepare($sql);
        $req->execute([
            ":id" => $id
        ]);
    }

    public function findUser($user)
    {
        $sql = "SELECT * from high_score WHERE name = :name";

        $req = $this->getDB()->prepare($sql);
        $req->execute([
            ":name" => $user
        ]);

        $user = $req->fetch(PDO::FETCH_OBJ);
        if (!empty($user)) {
            return $user->id;
        } else {
            return false;
        }
    }

    // public function modify($table, $id, $col, $value)
    // {
    //     $sql = "UPDATE :table SET :col = :value WHERE id = :id";

    //     $req = $this->getDB()->prepare($sql);
    //     return $req->execute([
    //         ":table" => $table,
    //         ":id" => $id,
    //         ":col" => $col,
    //         ":value" => $value
    //     ]);
    // }

    public function modifyNameScoreDB($id, $value)
    {
        $sql = "UPDATE high_score SET name = :value WHERE id = :id";

        $req = $this->getDB()->prepare($sql);
        return $req->execute([
            ":id" => $id,
            ":value" => $value
        ]);
    }
}
