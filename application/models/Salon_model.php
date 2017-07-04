<?php
require_once (CLASSES_DIR . "Salon_e.php");
require_once (CLASSES_DIR . "Book_e.php");
class Salon_model extends CI_Model
{
	private $table = "salon";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createSalon(Salon_e $salon)
	{
		$data = array(
            'name' 				   => $salon->getName(),
            'start_date'  		   => $salon->getStart_date(),
            'end_date'    		   => $salon->getEnd_date(),
            'id_livre'   		   => $salon->getId_livre(),
			'nb_max_user' 		   => $salon->getNb_max_user(),
			'statut'      		   => $salon->getStatut(),
			'nb_max_report_needed' => $salon->getNb_max_report_user()
        );

        return $this->db->insert('salon', $data);
	}

	public function getSalon($params = null)
	{
		$this->db->from($this->table);
		$this->db->order_by("start_date", "asc");
		$this->db->join("book", "book.id = salon.id_livre");

		if($params != null && $params > 0) {
			$this->db->get_where($this->table, array('id' => $id));
		} elseif ($params == "next") {
			$this->db->where(array('start_date >' => date('Y-m-d')));
		} else {
			$this->db->where(array('statut' => 1));
		}

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$rooms[] = [
					new Salon_e (
						$row->id,
						$row->name,
						$row->start_date,
						$row->end_date,
						$row->id_livre,
						$row->nb_max_user,
						$row->statut,
						$row->nb_max_report_needed
					), new Book_e (
						$row->id,
						$row->title,
						$row->description,
						$row->date,
						$row->author,
						$row->published,
						$row->editor,
						$row->collection,
						$row->ISBN10,
						$row->ISBN13
					)];
			}
			return $rooms;
		}
		return false;
	}
}
