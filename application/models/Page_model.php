<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once (CLASSES_DIR . "Page_e.php");
	class Page_model extends CI_Model {
		private $table = "pages";
		
		private function exists($name) {
			return $this->db->where('name', $name)->get($this->table)->num_rows() > 0;
		}
		public function addPage($name, $label, $title, $text) {
			return !$this->exists($name)
				&& $this->db->set('name', $name)
							->set('label', $label)
							->set('title', $title)
							->set('text', $text)
							->insert($this->table);
		}
		public function updatePage($id, $name, $label, $title, $text) {
			return !$this->exists($name)
				&& $this->db->set('name', $name)
							->set('label', $label)
							->set('title', $title)
							->set('text', $text)
							->where('id', $id)
							->update($this->table);
		}
		public function deletePage($name) {
			return $this->db->where('name', $name)->delete($this->table);
		}
		public function getPageByName($name) {
			$row = $this->db->where('name', $name)->get($this->table)->row();
			if (isset($row)) {
				$page = new Page_e($row->id, $row->name,$row->label,$row->title,$row->text);
				return $page;
			}
			return null;
		}
		public function getPage($id) {
			$row = $this->db->where('id', $id)->get($this->table)->row();
			if (isset($row)) {
				$page = new Page_VM();
				$page->id = $row->id;
				$page->name = $row->name;
				$page->label = $row->label;
				$page->title = $row->title;
				$page->text = $row->text;
				return $page;
			}
			return null;
		}
		public function getAllPages() {
			$result = $this->db->get($this->table)->result();
			$pages = array();
			foreach ($result as $row)
			{
				$page = new Page_e($row->id, $row->name,$row->label,$row->title,$row->text);
				
				$pages[] = $page;
			}
			return $pages;
		}
	}
?>