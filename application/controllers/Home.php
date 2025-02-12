<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model'); 
    }

    public function index()
    {
        $data['product_stats'] = $this->Product_model->get_product_status_count();
        $this->load->view('home_view', $data); 
    }
}
?>
