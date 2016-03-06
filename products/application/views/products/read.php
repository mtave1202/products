<div id="content" class="col-lg-12 col-sm-12">
	<ul class="breadcrumb">
		<li><a href="<?= site_url('products') ?>">検索</a></li>
		<li class="active">詳細(ID:<?=$id?>)</li>
	</ul>
	<?php $this->load->view('common/messages')?>
	<div class="row">
	  <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading" data-original-title="">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-zoom-in"></i> 検索</h3>
                </div>
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<th class="info">ID</th>
							<td><?= htmlspecialchars($product['id']) ?></td>
						</tr>
						<tr>
							<th class="info">状態</th>
							<td><?= Products_model::$status_labels[$product['status']]?></td>
						</tr>
						<tr>
							<th class="info">名前</th>
							<td><?= htmlspecialchars($product['name']) ?></td>
						</tr>
						<tr>
							<th class="info">価格</th>
							<td><?= htmlspecialchars(number_format($product['price'])) ?></td>
						</tr>
						<tr>
							<th class="info">在庫数</th>
							<td><?= htmlspecialchars(number_format($product['stock'])) ?></td>
						</tr>
						<tr>
							<th class="success">登録日</th>
							<td><?= $product['created_at'] ?></td>
						</tr>
						<tr>
							<th class="success">最終更新日</th>
							<td><?= $product['updated_at'] ?></td>
						</tr>
						<tr>
							<th class="success">削除日</th>
							<td><?= $product['deleted_timestamp'] ? date('Y-m-d H:i:s', $product['deleted_timestamp']) : '-' ?></td>
						</tr>
					</table>
				</div>
				<div class="panel-footer">
					<button class="btn btn-primary btn-update" data-id="<?=$id?>">
					  <i class="glyphicon glyphicon-edit icon-white"></i> 編集
					</button>
					<button class="btn btn-warning btn-create" data-id="<?=$id?>">
					  <i class="glyphicon glyphicon-plus icon-white"></i> コピー
					</button>
					<button class="btn btn-danger btn-delete" data-id="<?=$id?>">
						<i class="glyphicon glyphicon-trash icon-white"></i> 削除
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var url = "<?= site_url('products')?>";
$(document).on('click', '.btn-create', function(){
	location.href = url + '/create/' + $(this).data('id');
});
$(document).on('click', '.btn-update', function(){
	location.href = url + '/update/' + $(this).data('id');
});
$(document).on('click', '.btn-delete', function(){
	if(window.confirm('ID:'+$(this).data('id')+'の商品を削除します。よろしいですか？')) {
		location.href = url + '/delete/' + $(this).data('id');
	}
});
</script>