<?php
class Report_e
{
    private $id;
    private $id_user;
    private $id_user_reported;
    private $id_salon;
    private $reason;
    private $date;

    public function __construct($id, $id_user, $id_user_reported, $id_salon ,$reason, $date)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_user_reported = $id_user_reported;
        $this->id_salon = $id_salon;
        $this->reason = $reason;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getId_user_reported()
    {
        return $this->id_user_reported;
    }

    public function setId_user_reported($id_user_reported)
    {
        $this->id_user_reported = $id_user_reported;
    }

    public function getId_salon()
    {
        return $this->id_salon;
    }

    public function setId_salon($id_salon)
    {
        $this->id_salon = $id_salon;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

}
