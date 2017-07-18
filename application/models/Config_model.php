<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Config_model extends CI_Model {
	private $table = "config";
	
	public function getHomeTemplate() {
		$row = $this->db->where('key', 'home_template')->get($this->table)->row();
		return isset($row) ? $row->value : null;
	}
	public function setHomeTemplate($concept) {
		return $this->db->set('value', $concept)->where('key', 'home_template')->update($this->table);
	}
}
?>