<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->_library('controllers/products_library');
    }
    
	public function index()
	{
		$this->search();
	}
    
    public function search()
    {
        $products = $this->products_library->search();
        $vars = compact('products');
        $this->_render('products/search', $vars);
    }
	
	public function read($id)
	{
		$product = $this->products_library->get($id);
		if(!$product) {
			$this->_no_exists();
		}
		$vars = compact('id', 'product');
		$this->_render('products/read', $vars);
	}
	
	public function create($id = null)
	{
		$product = [];
		if($id) {
			// コピー元指定
			$product = $this->products_library->get($id);
			if(!$product) {
				set_danger_message('指定された商品が見つかりません[ID:'.$id.']');
				$id = null;
			} else {
				// 一部データを加工
				$product['name'] .= 'コピー';
				$product['stock'] = 0;
			}
		}
		if(!$product) {
			$product = [
				'name' => '',
				'status' => TRUE,
				'price' => 0,
				'stock' => 0,
			];
		}
		
		list($result, $data) = $this->products_library->validateCreate();
		if($result) {
			$id = $this->products_library->create($data);
			if($id) {
				set_success_message('商品を登録しました[ID:'. $id .']');
				$this->_redirect('products/create');
			} else {
				set_danger_message('登録に失敗しました');
			}
		}
		
		$vars = compact('id', 'product');
		$this->_render('products/create', $vars);
	}
	
	public function update($id)
	{
		$product = $this->products_library->get($id);
		if(!$product) {
			$this->_no_exists();
		}
		list($result, $data) = $this->products_library->validateUpdate();
		if($result) {
			if($this->products_library->update($id, $data)) {
				set_success_message('商品を更新しました[ID:'. $id .']');
				$this->_redirect('products/update/' . $id);
			} else {
				set_danger_message('更新に失敗しました');
			}
		}
		
		$vars = compact('id', 'product');
		$this->_render('products/update', $vars);
	}
	
	public function delete($id)
	{
		$product = $this->products_library->get($id);
		if(!$product) {
			$this->_no_exists();
		}
		if($this->products_library->delete($id)) {
			set_success_message('削除しました[ID:'.$id.']');
		} else {
			set_delete_message('削除に失敗しました[ID:'.$id.']');
		}
		$this->_redirect('products');
	}
}
