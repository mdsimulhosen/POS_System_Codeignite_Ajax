<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos_model extends CI_Model
{

    // Fetching supplier List
    public function select_supplier()
    {
        $this->db->order_by('supplier_name', 'ASC');
        $query = $this->db->get('supplier');
        return $query->result();
    }

    // Fetching Product List
    public function show_product_list()
    {
        $this->db->order_by('product_name', 'ASC');
        $query = $this->db->get('products');
        return $query->result();
    }

    // Add stock 
    public function addStock($stock_data)
    {
        $this->db->insert('stock', $stock_data);
    }

    // show data from  stock
    public function show_stock()
    {
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->join('supplier', 'supplier.supplier_id = stock.supplier_id');
        $this->db->join('products', 'products.product_id = stock.product_id');
        $query = $this->db->get();
        return $query->result();
    }

    // Show data in edit form 
    public function editStock($stock_id)
    {
        $this->db->where('stock_id', $stock_id);
        $query = $this->db->get('stock');
        if ($query) {
            return $query->row();
        }
    }


    // Update Product 
    public function updateStock($stock_data, $stock_id)
    {
        $this->db->where('stock_id', $stock_id);
        $this->db->update('stock', $stock_data);
    }

    // Delete Prodcut 
    public function deleteStock($stock_id)
    {
        $this->db->delete('stock', array('stock_id' => $stock_id));
    }









    // Sell Section start ==================================================
    public function select_customer()
    {
        $this->db->order_by('customer_name', 'ASC');
        $query = $this->db->get('customer');
        return $query->result();
    }
    public function stock_product()
    {
        $this->db->select('*');
        $this->db->from('stock');
        $this->db->join('products', 'products.product_id = stock.product_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function show_sell()
    {
        $this->db->select('*');
        $this->db->from('sell');
        $this->db->join('stock', 'sell.product_id = stock.product_id');
        $this->db->join('products', 'stock.product_id = products.product_id');
        $this->db->join('supplier', 'supplier.supplier_id = stock.supplier_id');
        $this->db->join('customer', 'sell.customer_id = customer.customer_id');
        $query = $this->db->get();
        return $query->result();
    }

    // Insert Data into table Sell 
    public function insertSell($sell_data)
    {
        if ($this->db->insert('sell', $sell_data)) {
            return true;
        }
    }

    // Edit Sell Table 
    public function editSell($sell_id)
    {
        $this->db->where('sell_id', $sell_id);
        $query = $this->db->get('sell');
        if ($query) {
            return $query->row();
        }
    }

    // Update Sell table Data 
    public function updateSell($sell_data, $sell_id)
    {
        $this->db->where('sell_id', $sell_id);
        $this->db->update('sell', $sell_data);
    }

    // Delete sell 
    public function deleteSell($sell_id)
    {
        $this->db->delete('sell', array('sell_id' => $sell_id));
    }
}
