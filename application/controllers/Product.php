<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session'); // Tambahkan session untuk flashdata
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

        // Flashdata untuk notifikasi
        $data['message'] = $this->session->flashdata('message');

        // Menampilkan view produk
        $this->load->view('product/index', $data);
    }

    public function store() {
        // Menetapkan aturan validasi untuk form tambah produk
        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
        $this->form_validation->set_rules('is_sell', 'Status Produk', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman tambah dengan error
            $this->session->set_flashdata('message', [
                'type' => 'danger',
                'text' => validation_errors()
            ]);
            redirect('product');
        } else {
            // Menyimpan data produk ke database
            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $this->input->post('is_sell')
            ];
            $this->Product_model->insert_product($data);

            // Set flashdata untuk SweetAlert2
            $this->session->set_flashdata('message', [
                'type' => 'success',
                'text' => 'Produk berhasil ditambahkan!'
            ]);

            redirect('product');
        }
    }

    public function update($id) {
        // Pastikan produk ada
        $product = $this->Product_model->get_product_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('message', [
                'type' => 'danger',
                'text' => 'Produk tidak ditemukan!'
            ]);
            redirect('product');
        }

        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
        $this->form_validation->set_rules('is_sell', 'Status Produk', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman edit dengan error
            $this->session->set_flashdata('message', [
                'type' => 'danger',
                'text' => validation_errors()
            ]);
            redirect('product');
        } else {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $this->input->post('is_sell')
            ];
            $this->Product_model->update_product($id, $data);

            // Set flashdata untuk SweetAlert2
            $this->session->set_flashdata('message', [
                'type' => 'success',
                'text' => 'Produk berhasil diperbarui!'
            ]);

            redirect('product');
        }
    }

    public function delete($id) {
        // Cek apakah produk ada sebelum menghapus
        if (!$this->Product_model->get_product_by_id($id)) {
            $this->session->set_flashdata('message', [
                'type' => 'danger',
                'text' => 'Produk tidak ditemukan!'
            ]);
            redirect('product');
        }

        $this->Product_model->delete_product($id);

        // Set flashdata untuk SweetAlert2
        $this->session->set_flashdata('message', [
            'type' => 'success',
            'text' => 'Produk berhasil dihapus!'
        ]);

        redirect('product');
    }
}
