<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_products($search = '', $sort_by = 'name', $sort_order = 'asc') {
        $allowed_sort_columns = ['name', 'price', 'stock', 'is_sell'];
        if (!in_array($sort_by, $allowed_sort_columns)) {
            $sort_by = 'name';
        }
        
        if (!in_array($sort_order, ['asc', 'desc'])) {
            $sort_order = 'asc';
        }

        if (!empty($search)) {
            $this->db->like('name', $search);
        }

        $this->db->order_by($sort_by, $sort_order);
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function insert_product($data) {
        $data['is_sell'] = isset($data['is_sell']) ? (int) $data['is_sell'] : 0;
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        $this->db->where('id', $id);

        if (isset($data['is_sell'])) {
            $data['is_sell'] = (int) $data['is_sell'];
        }

        return $this->db->update('products', $data);
    }

    public function delete_product($id) {
        return $this->db->delete('products', ['id' => $id]);
    }

    public function get_product_status_count() {
        $this->db->select('is_sell, COUNT(*) as count');
        $this->db->group_by('is_sell');
        $query = $this->db->get('products');

        $result = $query->result_array();
        $stats = ['dijual' => 0, 'tidak_dijual' => 0];

        foreach ($result as $row) {
            if ($row['is_sell'] == 1) {
                $stats['dijual'] = $row['count'];
            } else {
                $stats['tidak_dijual'] = $row['count'];
            }
        }

        return $stats;
    }
}
