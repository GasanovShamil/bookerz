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
			'id'				   => $salon->getId(),
            'name' 				   => $salon->getName(),
            'start_date'  		   => $salon->getStart_date(),
            'end_date'    		   => $salon->getEnd_date(),
            'id_livre'   		   => $salon->getId_livre(),
			'nb_max_user' 		   => $salon->getNb_max_user(),
			'status'      		   => $salon->getstatus(),
			'nb_max_report_needed' => $salon->getNb_max_report_user(),
			'closed'			   => $salon->getClosed()
        );

        return $this->db->insert('salon', $data);
	}

	public function getSalonByBook($id)
	{
		$this->db->from($this->table);
		$this->db->where(array('id_livre' => $id));

		$query = $this->db->get();
		$s = $query->row_array();
		$salon = new Salon_e(
			$s['id'],
			$s['name'],
			$s['start_date'],
			$s['end_date'],
			$s['id_livre'],
			$s['nb_max_user'],
			$s['status'],
			$s['nb_max_report_needed'],
			$s['closed']
		);
		return $salon;
	}

	public function getSalon($params = null)
	{
		$this->db->select("salon.id as sid, salon.name, salon.start_date, salon.end_date, salon.id_livre, salon.nb_max_user, salon.status, salon.nb_max_report_needed, salon.closed, book.*");
		$this->db->from($this->table);
		$this->db->order_by("salon.id", "desc");
		$this->db->join("book", "book.id = salon.id_livre");

		if($params != null && $params > 0) {
			$this->db->get_where($this->table, array('id' => $id));
		} elseif ($params == "next") {
			$this->db->where(array('closed' => 0));
			$this->db->where(array('start_date >' => date('Y-m-d')));
			$this->db->where(array('end_date <' => date('Y-m-d')));
		} elseif ($params == "finished") {
			$this->db->where(array('end_date <' => date('Y-m-d')));
		} elseif ($params == "closed") {
			$this->db->where(array('closed' => 1));
		} else {
			$this->db->where(array('salon.closed' => 0));
			$this->db->where(array('salon.status' => 1));
		}

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$rooms[] = [
					new Salon_e (
						$row->sid,
						$row->name,
						$row->start_date,
						$row->end_date,
						$row->id_livre,
						$row->nb_max_user,
						$row->status,
						$row->nb_max_report_needed,
						$row->closed
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

	public function checkSalonstatus()
	{
		$query = $this->db->from($this->table);
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($row->closed == 0) {
					if($row->status == 1) {
						if($row->end_date <= date('Y-m-d H:i:s')) {
							 $data = array('status' => 0);
							 $this->db->where('id', $row->id);
							 $this->db->update('salon', $data);
						}
					}
					if($row->status == 0) {
						if($row->start_date <= date('Y-m-d H:i:s')) {
							 $data = array('status' => 1);
							 $this->db->where('id', $row->id);
							 $this->db->update('salon', $data);
						}
					}
				}
			}
		}
	}

	public function getMaxReport($id)
	{
		$this->db->select('nb_max_report_needed');
		$this->db->from($this->table);
		$query = $this->db->get();
		$res = $query->row();
		return $res->nb_max_report_needed;
	}

	public function delete($id)
	{
	    $this->db->where('id', $id);
		$array = array('closed' => 1);
        $this->db->update('salon', $array);
        return true;
	}

	public function reopen($id)
	{
		$this->db->where('id', $id);
		$array = array('closed' => 0);
		$this->db->update('salon', $array);
		return true;
	}
}
