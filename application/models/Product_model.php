<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mendapatkan semua produk dengan pencarian & sorting
    public function get_all_products($search = '', $sort_by = 'name', $sort_order = 'asc') {
        // Validasi agar sorting hanya bisa dilakukan pada kolom yang benar
        $allowed_sort_columns = ['name', 'price', 'stock', 'is_sell'];
        if (!in_array($sort_by, $allowed_sort_columns)) {
            $sort_by = 'name';
        }
        
        if (!in_array($sort_order, ['asc', 'desc'])) {
            $sort_order = 'asc';
        }

        // Pencarian berdasarkan nama produk
        if (!empty($search)) {
            $this->db->like('name', $search);
        }

        $this->db->order_by($sort_by, $sort_order);
        $query = $this->db->get('products');
        return $query->result();
    }

    // Mendapatkan produk berdasarkan ID
    public function get_product_by_id($id) {
        $query = $this->db->get_where('products', ['id' => $id]);
        return $query->row(); // Mengembalikan satu baris data
    }

    // Menambahkan produk baru
    public function insert_product($data) {
        // Pastikan 'is_sell' bernilai 0 atau 1
        $data['is_sell'] = isset($data['is_sell']) ? (int) $data['is_sell'] : 0;
        return $this->db->insert('products', $data);
    }

    // Memperbarui data produk berdasarkan ID
    public function update_product($id, $data) {
        $this->db->where('id', $id);

        // Pastikan 'is_sell' bernilai 0 atau 1
        if (isset($data['is_sell'])) {
            $data['is_sell'] = (int) $data['is_sell'];
        }

        return $this->db->update('products', $data);
    }

    // Menghapus produk berdasarkan ID
    public function delete_product($id) {
        return $this->db->delete('products', ['id' => $id]);
    }
}
