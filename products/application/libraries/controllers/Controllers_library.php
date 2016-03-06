<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * コントローラ用ライブラリの親クラス
 */
class Controllers_library 
{
	/**
     * @params CI_Controller $CI 
     */
    protected $CI = null;

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	 * バリデーションの実行
	 * ルールは config/form_validatin.phpに記述
	 * @param string $rule_key
	 * @return array 0 => bool 結果, 1 => バリデーションされたPOSTパラメータ
	 */
	protected function _validate($rule_key)
	{
		$this->CI->load->library('form_validation');
		// 検証データの抽出
		$result = false;
		$data = [];
		// 検証処理を実行
		if($this->CI->form_validation->run($rule_key)) {
			$data = [];
			
			// POSTパラメータの抽出
			array_map(function ($field) use (&$data) {
				if($this->CI->input->post($field) !== "") {
					$data[$field] = $this->CI->input->post($field);
				}
			}, $this->CI->form_validation->get_fields());
			// エラーメッセージを削除
			$result = true;
        } else {
			// エラーメッセージ設定
			set_danger_message(validation_errors());
		}
		return [$result, $data];
	}
}
