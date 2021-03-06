<?php

class Users_model extends CI_Model {

    // NOTE - these roles must be added in this order to the database so that the role_id matches these values
    const DEFAULT_USER = 1;
    const WORKER_USER = 2;
    const ADMIN_USER = 3;
    
    public function __construct() {
        $this->load->database();
    }

    public function getallusers() {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->join('roles','users.role_id=roles.id');
        $query = $this->db->get();
        $results = $query->result();
        foreach ($results as &$result) {
            $result->role = $result->title;
        }
        return $results;
    }

    public function getallreservations() {        
        $this->db->select("*");
        $this->db->from('reservations');
        $this->db->join('items','reservations.item_id=items.id');
        $this->db->join('users','reservations.user_id=users.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getreservations($user_id) {        
        $this->db->select("*");
        $this->db->from('reservations');
        $this->db->join('items','reservations.item_id=items.id');
        $this->db->join('users','reservations.user_id=users.id');
        $this->db->where('users.id',$user_id);
        $query = $this->db->get();
        return $query->result();
    }

// old examples from news tutorial    
    public function set_news() {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );

        return $this->db->insert('news', $data);
    }

    public function delete_news($slug) {
        if (!$slug) {
            return false;
        }
        return $this->db->delete('news', array('slug' => $slug));
    }
    

}
