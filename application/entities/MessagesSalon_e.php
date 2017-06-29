<?php
class MessagesSalon_e
{
    private $id;
    private $id_salon;
    private $id_user;
    private $message;
    private $date;

    public function __construct($id, $id_salon, $id_user, $message, $date)
    {
        $this->id = $id;
        $this->id_salon = $id_salon;
        $this->id_user = $id_user;
        $this->message = $message;
        $this->date = $date;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }


    public function getId_salon(){
        return $this->id_salon;
    }

    public function setId_salon($id_salon){
        $this->id_salon = $id_salon;
    }


    public function getId_user(){
        return $this->id_user;
    }

    public function setId_user($id_user){
        $this->id_user = $id_user;
    }


    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
    }


    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
