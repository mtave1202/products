<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 商品コントローラ用ライブラリ
 */
require_once (__DIR__ . DIRECTORY_SEPARATOR . 'Controllers_library.php');
class Products_library extends Controllers_library
{
	protected $_create_params = ['name', 'status', 'price', 'stock'];
	protected $_update_params = ['name', 'status', 'price', 'stock'];
	
    public function __construct() 
    {
		parent::__construct();
        $this->CI->load->model('Products_model');
    }
    
	/**
	 * 検索処理
	 * @return array
	 */
    public function search()
    {
        $db =& $this->CI->Products_model->db;
        // POSTパラメータのチェック
        list($result, $data) = $this->validateSearch();
        if(!$result) {
			return [];
        }
        // ID 一致
        if(isset($data['id'])) {
            $db->where('id', $data['id']);
        }
        // 名前　一部一致
        if(isset($data['name'])) {
            $db->like('name', $data['name']);
        }
        // 値段 範囲
        if(isset($data['price_from'])) {
            $db->where('price >=', $data['price_from']);
        }
        if(isset($data['price_to'])) {
            $db->where('price <=', $data['price_to']);
        }
        // 在庫数 範囲
        if(isset($data['stock_from'])) {
            $db->where('stock >=', $data['stock_from']);
        }
        if(isset($data['stock_to'])) {
            $db->where('stock <=', $data['stock_to']);
        }
        // 状態
        if(isset($data['status'])) {
            $db->where('status', $data['status']);
        }
        return $this->CI->Products_model->getWhere();
    }
    
	/**
	 * 取得処理
	 * @param int $id
	 * @return array
	 */
    public function get($id)
    {
		$id = (int)$id;
		if(!$id) {
			return [];
		}
        return $this->CI->Products_model->get($id);
    }
    
	/**
	 * 新規登録処理
	 * @param array $set
	 * @return int ID
	 */
    public function create($set)
    {
        $params = [];
		foreach($this->_create_params as $key) {
			if(isset($set[$key])) {
				$params[$key] = $set[$key];
			}
		}
		return $this->CI->Products_model->insert($params);
    }
    
	/**
	 * 更新処理
	 * @param int $id
	 * @param array $set
	 * @return boolean
	 */
    public function update($id, $set)
    {
		$id = (int)$id;
		if(!$id) {
			return false;
		}
		$params = [];
		foreach($this->_update_params as $key) {
			if(isset($set[$key])) {
				$params[$key] = $set[$key];
			}
		}
        return $this->CI->Products_model->update($id, $set);
    }
    
	/**
	 * 削除処理
	 * @param int $id
	 * @return boolean
	 */
    public function delete($id)
    {
		$id = (int)$id;
		if(!$id) {
			return false;
		}
        return $this->CI->Products_model->delete($id);
    }
	
	/* ------------------------------------
	 * Validation関係のラッパー
	 * ------------------------------------*/
	public function validateSearch()
    {
        return $this->_validate('products/search');
    }
	
	public function validateCreate()
	{
		return $this->_validate('products/create');
	}
	
	public function validateUpdate()
	{
		return $this->_validate('products/update');
	}
}
