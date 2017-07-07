<?php
class Book_note_e
{
    private $id;
    private $id_user;
    private $id_book;
    private $note;
    private $date;

    public function __construct($id, $id_user, $id_salon, $note, $date)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_salon = $id_salon;
        $this->note = $note;
        $this->date = $date;
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

    public function getId_book()
    {
        return $this->id_book;
    }

    public function setId_book($id_book)
    {
        $this->id_book = $id_book;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
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
