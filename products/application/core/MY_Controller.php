<?php
/**
 * コントローララッパークラス
 *
 * @author Daisuke Abeyama
 * @category Controller
 * @package Core
 */
class MY_Controller extends CI_Controller 
{	
	/**
	 * ヘッダーのviewとパラメータ
	 * @params array $_view_headers string $view_path => array $params
	 */
	protected $_view_headers = [
		'header' => null,
	];
	/**
	 * フッターのviewとパラメータ
	 * @params array $_view_footers string $view_path => array $params 
	 */
	protected $_view_footers = [
		'footer' => null,
	];
	
	public function __construct()
	{
        parent::__construct();
	}
	
	
	/**
	 * モデル呼び出しのラッパー
	 * before:
	 *  $this->load->model('User_tbl_model');
	 *  $user = $this->User_tbl_model->get($id);
	 * after:
	 *  ex1)$user = $this->model('user_tbl')->get($id);
	 *  ex2)$user = $this->model('User_tbl')->get($id);
	 *  ex3)$user = $this->model('User_tbl_model')->get($id);
	 * @param string $_model_name モデル名
	 * @return CI_Model
	 */
	protected function _model($_model_name)
	{
		$model_name = ucfirst($_model_name);
		if(!preg_match('/.*_model$/', $model_name)) {
			$model_name = $model_name . '_model';
		}
		
		if(!isset($this->$model_name)) {
			$this->load->model($model_name);
		}
		return $this->$model_name;
	}
	
	/**
	 * ライブラリ呼び出しのラッパー
	 * @param string $library_name ライブラリ名
	 * @return CI_Library
	 */
	protected function _library($library_name)
	{
		list($name, $subdir) = $this->_explodeFilename($library_name);
		if(!isset($this->$name)) {
			$this->load->library($library_name);
	    }
	    return $this->$name;
	}
	
	
	protected function _explodeFilename($filename)
	{
		$class = str_replace('.php', '', trim($filename, '/'));

		// Was the path included with the class name?
		// We look for a slash to determine this
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, ++$last_slash);

			// Get the filename from the path
			$class = substr($class, $last_slash);
		} else {
			$subdir = '';
		}

		return [$class, $subdir];
	}
		
	/* ==============================================================
	 * View関連の処理
	 * ============================================================== */
	
	/**
	 * データが見つからなかった場合の処理
	 */
	protected function _no_exists()
	{
		set_danger_message('データが存在しません');
		$route = $this->router->fetch_directory() . $this->router->fetch_class();
		$this->_redirect($route);
	}
	
	/**
	 * redirectのラッパー
	 * @param string $url
	 */
	protected function _redirect($url)
	{
		redirect($url, 'location', 302);
	}

	
	/**
	 * @param string $view_name
	 * @param array $params
	 */
	protected function _render($view_name, $params = null)
	{
		$this->_renders([$view_name => $params]);
	}
	
	/**
	 * 
	 * @param array $views string $view_name => array $params
	 */
	protected function _renders($views)
	{
		// ヘッダー描写
		foreach($this->_view_headers as $_view => $_params) {
			$this->load->view($_view, $_params);
		}
		
		// メイン描写
		foreach($views as $_view => $_params) {
			$this->load->view($_view, $_params);
		}
		
		// フッター描写
		foreach($this->_view_footers as $_view => $_params) {
			$this->load->view($_view, $_params);
		}
	}
	
	/**
	 * 
	 * @param type $view_name
	 * @param type $params
	 * @param type $is_push
	 */
	protected function _add_header($view_name, $params, $is_push = true)
	{
		if($is_push) {
			$this->_view_headers[$view_name] = $params; 
		} else {
			$this->_view_headers = [$view_name => $params] + $this->_view_headers;
		}
	}
	
	/**
	 * 
	 * @param type $view_name
	 * @param type $params
	 * @param type $is_push
	 */
	protected function _add_footer($view_name, $params, $is_push = true)
	{
		if($is_push) {
			$this->_view_footers[$view_name] = $params; 
		} else {
			$this->_view_footers = [$view_name => $params] + $this->_view_footers;
		}
	}
}
