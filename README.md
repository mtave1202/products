# 商品管理サンプル

商品の検索・登録・更新・削除を行うシステムのサンプルです。

## ファイル構成

```
Vagrantfile
createdb.sql
provision.sh
products/
├── application/
├── composer.json
├── composer.lock
├── public/
│   ├── .htaccess
│   └── index.php
└── vendor/
  └── codeigniter/
       └── framework/
           └── system/

```

## 環境
* Apache 2.2.15
* PHP 5.6.x
* Codeigniter 3.x
* mysql 5.5.x
* Composer
* Git

## 実行
（要Vagrant実行環境）

git clone したディレクトリで vagrant up  
起動完了後、http://192.168.56.10/ へアクセス

## システム概要

### 画面遷移図
![画面遷移](https://github.com/mtave1202/products/blob/master/img/seni.png)

### 機能一覧

| 機能名 | path | 備考 |  
| --- | --- | --- |
| 商品検索 | products/search |インデックスページも兼ねる |
| 商品登録 | products/create | |
| 商品コピー | products/create | |
| 商品詳細 | products/read | |
| 商品更新 | products/update | |
| 商品削除 | products/delete | |

#### 商品検索
商品ID、商品名（一部一致）、状態（有効/無効）、価格（from/to）、在庫数（from/to）でのAND検索が可能。  
検索結果から、商品詳細・商品コピー・商品更新・商品削除の処理をそれぞれ行うことが出来る。  
  
#### 商品登録/商品コピー
商品の新規登録を行う。  
コピー元商品IDが指定されている場合、コピー元商品の情報が初期状態で入力された状態で登録することが出来る。  
  
#### 商品詳細
商品の詳細情報を閲覧する。  
商品コピー・商品更新・商品削除の処理をそれぞれ行うことが出来る。  
  
#### 商品更新
商品の更新を行う。  
  
#### 商品削除
商品の論理削除を行う。  
削除が完了すると商品検索画面へ遷移。  
