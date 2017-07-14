<?php
require_once (CLASSES_DIR . "Book_e.php");
class Book_model extends CI_Model {
	private $table = "book";
	private $result;
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	 
	public function record_count() {
		return $this->db->count_all ( $this->table );
	}
	
	public function getBooks($search_string=null, $category = null, $order=null, $order_type='Asc', $limit = NULL, $start = NULL) {
		if (! is_null ( $limit ) && ! is_null ( $start )) {
			$this->db->limit ( $limit, $start );
		}

		$this->db->select('*');
		$this->db->from($this->table);

		if($search_string){
			$this->db->like('title', $search_string);
		}

		if ($category){
			$this->db->like('collection',$category);
		}

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
			$this->db->order_by('id', $order_type);
		}

		$query = $this->db->get();

		$books = array ();
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$books [] = new Book_e (
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
						);
			}
			return $books;
		}
		return false;
	}

	public function getBookById($id) {
		$query = $this->db->get_where ( $this->table, array ('id' => $id) );
		$row = $query->row ();

		if (isset ( $row )) {
			$book = new Book_e (
					$row->id,
					$row->title,
					$row->description,
					$row->date,
					$row->author,
					$row->published,
					$row->editor,
					$row->collection,
					$row->ISBN10,
					$row->ISBN13 );

			return $book;
		}
		return null;
	}

	public function checkBookExist($isbn){
        if(strlen($isbn) == 10){
            $query =  $this->db->get_where('book', array('ISBN10' => $isbn));
        }else{
            $query =  $this->db->get_where('book', array('ISBN13' => $isbn));
        }
        if (!empty($query->result())){
            return true;
        }else{
            return false;
        }
    }

    public function getAllBookUser($idUser, $idStatut){
        $this->db->select('*');
        $this->db->from('book');
        $this->db->join('has_book', 'has_book.id_book = book.id');
        $this->db->where(array('book.statut' => $idStatut, 'has_book.id_user' => $idUser));
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllBook(){
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function addBookToUser($data){
        $data = array(
            'title' => 'My title',
            'name' => 'My Name',
            'date' => 'My date'
        );

        $this->db->insert('mytable', $data);
    }

	public function getJsonBook($id) {
		$query = $this->db->get_where ( $this->table, array ('id' => $id) );
		$row = $query->row();

		if (isset($row)){
			return $row;
		}
	}

}
