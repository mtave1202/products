<?php
/**
 * 基本モデルのラッパークラス
 * 主キーを元にした各種処理と、更新・削除処理を実装
 * 継承先クラスでは、登録や更新に用いるデータを作成し、
 * DBへの処理はこのクラスで行う
 * 
 * @author Daisuke Abeyama
 * @category Model
 * @package Core
 */
class MY_Model extends CI_Model
{
	/**
	 * @param CI_Controller $CI
	 * @access protected
	 */
	protected $CI;
	/**
	 * @static
	 * @params string $table テーブル名
	 * @access protected
	 */
	protected static $table = null;
	/**
	 * @static
	 * @params string $primary_key 主キーカラム
	 * @access protected
	 */
	protected static $primary_key = 'id';
	/**
	 * @static
	 * @type boolean $is_created_at 作成日が有効か
	 * @access protected
	 */
	protected static $is_created_at = true;
	/**
	 * @static
	 * @params boolean $is_updated_at 更新日が有効か
	 * @access protected
	 */
	protected static $is_updated_at = true;
	/**
	 * @static
	 * @params string $created_at 作成日カラム
	 * @access protected
	 */
	protected static $created_at = 'created_at';
	/**
	 * @static
	 * @params string $updated_at 更新日カラム
	 * @access protected
	 */
	protected static $updated_at = 'updated_at';
	/**
	 * @static
	 * @params string $time_format 日付データのフォーマット
	 * @access protected
	 */
	protected static $time_format = 'Y-m-d H:i:s';
	/**
	 * @static
	 * @params boolean $is_softdelete 論理削除を行うか
	 * @access protected
	 */
	protected static $is_softdelete = false;
	/**
	 * @static
	 * @params string $deleted_at 削除日カラム
	 * @access protected
	 */
	protected static $deleted_at = 'deleted_timestamp';

	/**
	 * テーブル名が未設定の場合例外を投げる
	 * @throws Exception
	 */
	function __construct()
	{
		parent::__construct();
		if(is_null(static::$table)) {
			throw new Exception('table name is not set');
		}
		$this->CI =& get_instance();
	}
	
	/**
	 * 主キーを元にデータを1件取得します
	 * @param int $id
	 */
	public function get($id)
	{
		$where = [static::$primary_key => $id];
		$records = $this->getWhere($where, NULL, 1);
		$record = null;
		if(count($records) === 1) {
			$record = $records[0];
		}
		return $record;
	}
	
	public function gets($ids)
	{
		if(empty($ids)) {
			return [];
		}
		$this->db->where_in(static::$primary_key, $ids);
		return $this->getWhere();
	}
	
	/**
	 * データ一覧を取得します。
	 *
	 * @access public
	 * @param array $where 条件配列
	 * @param int $limit 取得件数
	 * @param int $offset 開始位置
	 * @return array データ一覧
	 */
	public function getWhere($where = NULL, $limit = NULL, $offset = 9) 
	{
		if($limit) {
			$this->db->limit($limit, $offset);
		}
		if($where) {
			$this->db->where($where);
		}
		
		$query = $this->db->get(static::$table);
		$records = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $_record) {
				if ($this->_validateRecord($_record)) {
					$records[] = $_record;
				}
			}
		}
		return $records;
	}
	
	/**
	 * 全データ取得
	 * @return array
	 */
	public function getAll()
	{
		return $this->getWhere();
	}
	
	/**
	 * 並べ替え順序を設定
	 * @param string $order 並べ替え配列
	 */
	public function setOrder($order)
	{
		$this->db->order_by($order);
	}
	
	/**
	 * レコードが有効かを返します。
	 *
	 * @access public
	 * @param array $record レコード
	 * @return boolean 真偽
	 */
	protected function _validateRecord($record)
	{
		return true;
	}
	
	public function insert($set)
	{
		if(!is_array($set)) {
			throw new InvalidArgumentException();
		}
		return $this->_dbInsert($set);
	}
	
	/**
	 * データを追加します。
	 * @access private
	 * @param array $set
	 * @return mixied 追加したレコードの主キーの値
	 */
	private function _dbInsert($set)
	{
		// 登録日を追加
		if(static::$is_created_at && !isset($set[static::$created_at])) {
			$set[static::$created_at] = date(static::$time_format);
		}
		// 更新日を追加
		if(static::$is_updated_at && !isset($set[static::$updated_at])) {
			$set[static::$updated_at] = date(static::$time_format);
		}
		$id = null;
		if($this->db->insert(static::$table, $set)) {
			$id = $this->db->insert_id();
		}
		return $id;
	}
	
	public function update($id, $set)
	{
		if(!is_array($set)) {
			throw new InvalidArgumentException();
		}
		return $this->_dbUpdate($id, $set);
	}
	
	/**
	 * 主キーを元にデータを更新します。
	 * @access private
	 * @param int $id
	 * @param array $set
	 * @see _dbUpdateWhere
	 * @return boolean
	 */
	private function _dbUpdate($id, $set) {
		$where = [static::$primary_key => $id];
		return $this->_dbUpdateWhere($set, $where);
	}
	
	public function updateWhere($set, $where = NULL)
	{
		if(!is_array($set)) {
			throw new InvalidArgumentException();
		}
		return $this->_dbUpdateWhere($set, $where);
	}
	
	/**
	 * データを更新します
	 * @param array $set
	 * @param array $where
	 * @return boolean
	 */
	private function _dbUpdateWhere($set, $where = NULL)
	{
		// 更新日を追加
		if(static::$is_updated_at && !isset($set[static::$updated_at])) {
			$set[static::$updated_at] = date(static::$time_format);
		}
		return $this->db->update(static::$table, $set, $where);
	}
	
	public function delete($id)
	{
		return $this->_dbDelete($id);
	}
	
	/**
	 * 主キーを元にデータを削除します。
	 * @access public
	 * @param string $id 主キー
	 * @see _deleteWhere
	 */
	private function _dbDelete($id) {
		$where = [static::$primary_key => $id];
		return $this->_dbDeleteWhere($where);
	}
	
	public function deleteWhere($where = NULL)
	{
		return $this->_dbDeleteWhere($where);
	}
	
	/**
	 * 条件を指定してデータを削除します。
	 * @access public
	 * @param type $where
	 */
	private function _dbDeleteWhere($where = NULL) 
	{
		if(static::$is_softdelete) {
			// 論理削除
			$set = [
				static::$deleted_at => time(),
			];
			return $this->updateWhere($set, $where);
		} else {
			// 物理削除
			return $this->db->delete(static::$table, $where);
		}
	}
    
    protected function _checkInt($var)
    {
        if(is_array($var)) {
            foreach($var as $v) {
                if(!$this->_checkInt($v)) {
                    return false;
                }
            }
        } else {
            $var = (int)$var;
            if(!$var) {
                return false;
            }
        }
        return true;
    }
}
