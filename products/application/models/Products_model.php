<?php
class Products_model extends MY_Model
{
    protected static $table = 'products';
    protected static $is_softdelete = TRUE;
    
	public static $status_labels = [
		0 => '<label class="label label-danger">無　効</label>',
		1 => '<label class="label label-primary">有　効</label>',
	];
	
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * カテゴリIDからデータの取得
     * @param int $category_id
     * @return array
     * @throws InvalidArgumentException
     */
    public function getsFromCategoryId($category_id)
    {
        if(!$this->_checkInt($category_id) || !is_numeric($category_id)) {
            throw new InvalidArgumentException();
        }
        
        return $this->getWhere([
            'category_id' => $category_id,
        ]);
    }
	
	protected function _validateRecord($record) 
	{
		return (!$record['deleted_timestamp']);
	}
}
