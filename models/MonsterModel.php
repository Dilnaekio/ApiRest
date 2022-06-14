<?php

class Monsters
{
    private $id;
    private $name;
    private $life;
    private $atk;
    private $def;
    private $img;
    private $score;
    private $role;

    public function __construct($id, $name, $life, $atk, $def, $img, $score, $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->life = $life;
        $this->atk = $atk;
        $this->def = $def;
        $this->img = $img;
        $this->score = $score;
        $this->role = $role;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of life
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Set the value of life
     *
     * @return  self
     */
    public function setLife($life)
    {
        $this->life = $life;

        return $this;
    }

    /**
     * Get the value of atk
     */
    public function getAtk()
    {
        return $this->atk;
    }

    /**
     * Set the value of atk
     *
     * @return  self
     */
    public function setAtk($atk)
    {
        $this->atk = $atk;

        return $this;
    }

    /**
     * Get the value of def
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * Set the value of def
     *
     * @return  self
     */
    public function setDef($def)
    {
        $this->def = $def;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
