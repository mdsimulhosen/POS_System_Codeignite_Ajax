<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pos_model');
	}

	// show data from product table 
	public function index()
	{
		$result['rows'] = $this->pos_model->select_supplier();
		$result['stock'] = $this->pos_model->show_stock();
		$result['product_list'] = $this->pos_model->show_product_list();

		$this->load->view('product', $result);
	}


	// insert data in table Product & Stock Also 
	public function add_stock()
	{
		$stock_data = [
			'supplier_id' => $this->input->post('supplier_id'),
			'product_id' => $this->input->post('product_id'),
			'quantity' => $this->input->post('quantity'),
		];

		$this->pos_model->addStock($stock_data);
	}

	// Edit Product and Stock 
	public function edit_stock($stock_id)
	{
		echo json_encode($this->pos_model->editStock($stock_id));
	}

	// Update Product 
	public function update_stock($stock_id)
	{
		$stock_data = [
			'stock_id' => $this->input->post('stock_id'),
			'product_id' => $this->input->post('product_id'),
			'supplier_id' => $this->input->post('supplier_id'),
			'quantity' => $this->input->post('quantity'),
		];
		json_encode($this->pos_model->updateStock($stock_data, $stock_id));
	}

	// Delete Data 
	public function delete_stock($stock_id)
	{
		$this->pos_model->deleteStock($stock_id);
	}








	// ================== ******************************Customer Page *********************================= 
	public function shop()
	{
		$data['customer'] = $this->pos_model->select_customer();
		$data['stock_product'] = $this->pos_model->stock_product();
		$data['sells'] = $this->pos_model->show_sell();
		$this->load->view('shop', $data);
	}

	// Insert Data into Sell table 
	public function insert_sell()
	{
		$sell_data = [
			'customer_id' => $this->input->post('customer_id'),
			'product_id' => $this->input->post('product_id'),
			'sell_quantity' => $this->input->post('sell_quantity'),
		];

		$this->pos_model->insertSell($sell_data);
	}

	// Edit data from sell Table 
	public function edit_sell($sell_id)
	{
		echo json_encode($this->pos_model->editSell($sell_id));
	}

	// Update Sell table 
	public function update_sell($sell_id)
	{
		$sell_data = [
			'sell_id' => $this->input->post('sell_id'),
			'customer_id' => $this->input->post('customer_id'),
			'product_id' => $this->input->post('product_id'),
			'sell_quantity' => $this->input->post('sell_quantity'),
		];
		json_encode($this->pos_model->updateSell($sell_data, $sell_id));
	}

	// Delete Data 
	public function delete_sell($sell_id)
	{
		$this->pos_model->deleteSell($sell_id);
	}
}
