<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $search = $this->input->get('search');
        $sort_by = $this->input->get('sort_by') ?: 'name';
        $sort_order = $this->input->get('sort_order') ?: 'asc';

        // Mengambil data produk dengan pencarian dan pengurutan
        $data['products'] = $this->Product_model->get_all_products($search, $sort_by, $sort_order);
        $data['search'] = $search;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        // Menampilkan view produk
        $this->load->view('product/index', $data);
    }

    public function create() {
        // Menampilkan halaman form tambah produk
        $this->load->view('product/create');
    }

    public function store() {
        // Menetapkan aturan validasi untuk form tambah produk
        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
        $this->form_validation->set_rules('is_sell', 'Status Produk', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('product/create');
        } else {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $this->input->post('is_sell') 
            ];
            $this->Product_model->insert_product($data);
            redirect('product');
        }
    }
    public function edit($id) {
        $data['product'] = $this->Product_model->get_product_by_id($id);
        if (!$data['product']) show_404(); 
        $this->load->view('product/edit', $data);
    }

    public function update($id) {
        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
        $this->form_validation->set_rules('status', 'Status Produk', 'required|in_list[Dijual,Tidak Dijual]');

        if ($this->form_validation->run() == FALSE) {
            $data['product'] = $this->Product_model->get_product_by_id($id);
            if (!$data['product']) show_404();
            $this->load->view('product/edit', $data);
        } else {
            $is_sell_value = ($this->input->post('status') == 'Dijual') ? 1 : 0;

            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $is_sell_value
            ];

            $this->Product_model->update_product($id, $data);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Produk berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada perubahan pada produk.');
            }

            redirect('product');
        }
    }

    public function delete($id) {
        if (!$this->Product_model->get_product_by_id($id)) show_404();
        $this->Product_model->delete_product($id);
        redirect('product');
    }
}
?>
