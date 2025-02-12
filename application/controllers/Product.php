<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
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

        // Memeriksa apakah validasi berhasil
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman form tambah produk
            $this->load->view('product/create');
        } else {
            // Menyimpan data produk ke database
            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $this->input->post('is_sell') // 0 atau 1
            ];
            $this->Product_model->insert_product($data);
            // Setelah data disimpan, arahkan kembali ke halaman produk
            redirect('product');
        }
    }

    public function edit($id) {
        // Mengambil data produk berdasarkan ID untuk diubah
        $data['product'] = $this->Product_model->get_product_by_id($id);
        if (!$data['product']) show_404(); // Jika produk tidak ditemukan, tampilkan error 404
        // Menampilkan form untuk mengedit produk
        $this->load->view('product/edit', $data);
    }

    public function update($id) {
        // Menetapkan aturan validasi untuk form edit produk
        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
        $this->form_validation->set_rules('is_sell', 'Status Produk', 'required|in_list[0,1]');

        // Memeriksa apakah validasi berhasil
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form edit dengan data yang sudah ada
            $data['product'] = $this->Product_model->get_product_by_id($id);
            if (!$data['product']) show_404(); // Jika produk tidak ditemukan, tampilkan error 404
            $this->load->view('product/edit', $data);
        } else {
            // Menyimpan perubahan produk
            $data = [
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'is_sell' => $this->input->post('is_sell') // 0 atau 1
            ];
            $this->Product_model->update_product($id, $data);
            // Setelah data diperbarui, arahkan kembali ke halaman produk
            redirect('product');
        }
    }

    public function delete($id) {
        // Mengecek apakah produk ada sebelum dihapus
        if (!$this->Product_model->get_product_by_id($id)) show_404();
        // Menghapus produk berdasarkan ID
        $this->Product_model->delete_product($id);
        // Setelah dihapus, arahkan kembali ke halaman produk
        redirect('product');
    }
}
?>
