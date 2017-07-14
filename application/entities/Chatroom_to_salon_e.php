<?php
class Chatroom_to_salon_e
{
    private $id;
    private $id_user;
    private $id_salon;

    public function __construct($id, $id_user, $id_salon)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_salon = $id_salon;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getId_salon()
    {
        return $this->id_salon;
    }

    public function setId_salon($id_salon)
    {
        $this->id_salon = $id_salon;
    }
}
