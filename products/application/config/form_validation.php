<?php
$config = [
	'products/search' => [
		[
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'integer',
            'type'  => 'text',
        ],
        [
            'field' => 'name',
            'label' => '商品名',
            'rules' => 'max_length[255]',
            'type'  => 'text',
        ],
        [
            'field' => 'status',
            'label' => '状態',
            'rules' => 'integer',
            'type'  => 'radio',
        ],
        [
            'field' => 'price_from',
            'label' => '価格(from)',
            'rules' => 'integer',
            'type'  => 'number',
        ],
        [
            'field' => 'price_to',
            'label' => '価格(to)',
            'rules' => 'integer',
            'type'  => 'number',
        ],
        [
            'field' => 'stock_from',
            'label' => '在庫(from)',
            'rules' => 'integer',
            'type'  => 'number',
        ],
        [
            'field' => 'stock_to',
            'label' => '在庫(to)',
            'rules' => 'integer',
            'type'  => 'number',
        ],
	],
	'products/create' => [
        [
            'field' => 'name',
            'label' => '商品名',
            'rules' => 'required|max_length[255]',
            'type'  => 'text',
        ],
        [
            'field' => 'status',
            'label' => '状態',
            'rules' => 'required|integer',
            'type'  => 'radio',
        ],
        [
            'field' => 'price',
            'label' => '価格',
            'rules' => 'required|integer',
            'type'  => 'number',
        ],
        [
            'field' => 'stock',
            'label' => '在庫数',
            'rules' => 'required|integer',
            'type'  => 'number',
        ],
	],
	'products/update' => [
		[
            'field' => 'name',
            'label' => '商品名',
            'rules' => 'required|max_length[255]',
            'type'  => 'text',
        ],
        [
            'field' => 'status',
            'label' => '状態',
            'rules' => 'required|integer',
            'type'  => 'radio',
        ],
        [
            'field' => 'price',
            'label' => '価格',
            'rules' => 'required|integer',
            'type'  => 'number',
        ],
        [
            'field' => 'stock',
            'label' => '在庫数',
            'rules' => 'required|integer',
            'type'  => 'number',
        ],
	],
];
