<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Base_query extends CI_Model {
	public function get_row($tbl = '', $params = []) {
		$this->db->from($tbl)
			->where($params);
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}
}