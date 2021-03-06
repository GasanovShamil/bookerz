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
						$row->ISBN10,
						$row->ISBN13,
						$row->accepted,
						$row->cover
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
					$row->ISBN10,
					$row->ISBN13,
					$row->accepted,
					$row->cover);

			return $book;
		}
		return null;
	}

	public function checkBookExist($isbn13, $isbn10){
        $query =  $this->db->get_where('book', array('ISBN10' => $isbn10, 'ISBN13' => $isbn13));
        if (!empty($query->result())){
            return true;
        }else{
            return false;
        }
    }

   public function addBookSuggest($data){
        $data = array(
            'id_book' => $data['id_book'],
            'id_user' => $data['id_user']
        );

        return $this->db->insert('suggest', $data);
    }

    public function addBook($data){
        $data = array(
            'title' => $data['title'],
            'description' => $data['description'],
            'date' => $data['date'],
            'author' => $data['author'],
            'published' => $data['published'],
            'editor' => $data['editor'],
            'cover' => $data['cover'],
            'ISBN10' => $data['isbn10'],
            'ISBN13' => $data['isbn13'],
            'accepted' => $data['accepted'],
        );
        $this->db->insert('book', $data);
        return $this->db->insert_id();
    }

    public function getAllBookUser($idUser, $idStatut){
        $this->db->select('*');
        $this->db->from('book');
        $this->db->join('has_book', 'has_book.id_book = book.id');
        $this->db->where(array('book.accepted' => $idStatut, 'has_book.id_user' => $idUser));
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllBookSuggest(){
        $this->db->select('*');
        $this->db->from('book');
        $this->db->where(array('book.accepted' => 0));
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllBook(){
        $this->db->select('*');
        $this->db->from('book');
        $this->db->where(array('book.accepted' => 1));
        $query = $this->db->get();
        return $query->result();
    }

    public function checkUserHasBook($idBook, $idUser){
        $this->db->select('*');
        $this->db->from('has_book');
        $this->db->where(array('has_book.id_book' => $idBook, 'has_book.id_user' => $idUser));
        $query = $this->db->get();
        return $query->result();
    }

    public function addBookToUser($data){
        $data = array(
            'id_book' => $data['id_book'],
            'id_user' => $data['id_user'],
            'id_status' => 1
        );

        return $this->db->insert('has_book', $data);
    }

	public function getJsonBook($id) {
		$query = $this->db->get_where ( $this->table, array ('id' => $id) );
		$row = $query->row();

		if (isset($row)){
			return $row;
		}
	}
	
	public function getBooksOnTop() {
		$this->db->select('*');
		$this->db->from('book');
		$this->db->join('on_top','on_top.id_book = book.id', 'inner');
				
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
						$row->ISBN10,
						$row->ISBN13,
						$row->accepted,
						$row->cover
						);
			}
			return $books;
		}else{
			return null;
		}
	}

	public function getBookAndStatus($id){
        $this->db->select('*');
        $this->db->from('book');
        $this->db->join('has_book', 'has_book.id_book = book.id');
        $this->db->join('status_book', 'status_book.id = has_book.id_status');
        $this->db->where(array('book.id' => $id, 'has_book.id_book' => $id));
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getBookAndStatus2($id){
    	$this->db->from('book');
    	$this->db->where('id' , $id);
    	$query = $this->db->get();
    	return $query->result();
    }
	
	public function bookListing($searchText = NULL, $category = NULL, $order=null, $status = NULL, $page , $segment) {
		
		$this->db->limit ( $page, $segment);
		
		
		$this->db->select('b.*');
		$this->db->from($this->table.' b');
		
		if($searchText){
			$this->db->like('title', $searchText);
		}
		
		if ($category != 0){
			$this->db->join('book_category bc','bc.id_book = b.id', 'inner')->where('bc.id_category', $category);
		}
		
		if($status != -1){
			$this->db->like('accepted', $status);
		}
		
		if($order){
			$this->db->order_by($order);
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
						$row->ISBN10,
						$row->ISBN13,
						$row->accepted,
						$row->cover
						);
			}
			return $books;
		}
		return false;
	}
	
	public function bookListingCount($searchText=NULL, $category = NULL,  $order=null, $status = NULL) {
		
		$this->db->select('b.*');
		$this->db->from($this->table.' b');
		
		if($searchText){
			$this->db->like('title', $searchText);
		}
		
		if ($category != 0){
			$this->db->join('book_category bc','bc.id_book = b.id', 'inner')->where('bc.id_category', $category);
		}
		
		if($status != -1){
			$this->db->like('accepted', $status);
		}
		
		if($order){
			$this->db->order_by($order);
		}
		
		$query = $this->db->get();
		
		return $query->num_rows ();
	}
	
	
	public function hasOpenRoom($id){
		$this->db->select('*');
		$this->db->from('salon');
		$this->db->where('id_livre', $id);
		$this->db->where('closed', 0);
		$this->db->get();
		return  $this->db->affected_rows () > 0;
	}
	
	public function deleteBook($id){
		$this->db->where('id_book', $id);
		$this->db->delete('book_category');
		
		$this->db->where('id_book', $id);
		$this->db->delete('has_book');
		
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		return  $this->db->affected_rows () > 0;
	}
	
	public function updateBook($data, $id){
		$id = isset ( $id ) ? $id : $this->session->userdata ( 'user_id' );
		$this->db->where('id',$id);
		$this->db->update($this->table, $data);
		return  $this->db->affected_rows () == 1;
	}

	public function updateStatusBook($data){
        $this->db->set('id_status', $data['id_status']);
        $this->db->where('id_user', $data['id_user']);
        $this->db->where('id_book', $data['id_book']);

        return $this->db->update('has_book');
    }

}