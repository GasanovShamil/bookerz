<?php
class UsersSalon_e
{
    private $id;
    private $id_user;
    private $id_salon;
    private $role;
    private $nb_signaled;

    public function __construct($id, $id_user, $id_salon, $role, $nb_signaled)
    {
        $this->id           = $id;
        $this->id_user      = $id_user;
        $this->id_salon     = $id_salon;
        $this->role         = $role;
        $this->nb_signaled  = $nb_signaled;
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


    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }


    public function getNb_signaled()
    {
        return $this->nb_signaled;
    }

    public function setNb_signaled($nb_signaled)
    {
        $this->nb_signaled = $nb_signaled;
    }


}
