<?php
class Salon_e
{
    private $id;
    private $name;
    private $start_date;
    private $end_date;
    private $id_livre;
    private $nb_max_user;
    private $status;
    private $nb_max_report_user;
    private $closed;

    public function __construct($id, $name, $start_date, $end_date, $id_livre, $nb_max_user, $status, $nb_max_report_needed, $closed)
    {
        $this->id                   = $id;
        $this->name                 = $name;
        $this->start_date           = $start_date;
        $this->end_date             = $end_date;
        $this->id_livre             = $id_livre;
        $this->nb_max_user          = $nb_max_user;
        $this->status               = $status;
        $this->nb_max_report_user   = $nb_max_report_needed;
        $this->closed               = $closed;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getStart_date()
    {
        return $this->start_date;
    }

    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;
    }


    public function getEnd_date()
    {
        return $this->end_date;
    }

    public function setEnd_date($end_date)
    {
        $this->end_date = $end_date;
    }



    public function getId_livre()
    {
        return $this->id_livre;
    }

    public function setId_livre($id_livre)
    {
        $this->id_livre = $id_livre;
    }


    public function getNb_max_user()
    {
        return $this->nb_max_user;
    }

    public function setNb_max_user($nb_max_user)
    {
        $this->nb_max_user = $nb_max_user;
    }


    public function getstatus()
    {
        return $this->status;
    }

    public function setstatus($status)
    {
        $this->status = $status;
    }


    public function getNb_max_report_user()
    {
        return $this->nb_max_report_user;
    }

    public function setNb_max_report_user($nb_max_report_user)
    {
        $this->nb_max_report_user = $nb_max_report_user;
    }


    public function getClosed()
    {
        return $this->closed;
    }

    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

}
