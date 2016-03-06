<div id="content" class="col-lg-12 col-sm-12">
	<?php $this->view('common/messages') ?>
	<div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-original-title="">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> 検索</h3>
                </div>
                <div class="panel-body">
                    <?= form_open('products/search')?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="number" name="id" value="<?= set_value('id'); ?>" class="form-control" id="id" placeholder="" min="1">
                    </div>
                    <div class="form-group">
                        <label for="name">商品名（一部一致）</label>
                        <input type="text" name="name" value="<?= set_value('name'); ?>" class="form-control" id="name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="name">状態</label>
                        <label for="status-1"><input type="radio" name="status" value="1" id="status-1" <?= set_radio('status', "1", TRUE)?>> 有効</label>
                        <label for="status-0"><input type="radio" name="status" value="0" id="status-0" <?= set_radio('status', "0")?>> 無効</label>
                    </div>
                    <div class="form-group form-inline">
                        <label>価格</label>
                        <div class="form-group">
                            <input type="number" name="price_from" value="<?= set_value('price_from'); ?>" class="form-control" id="price_from" placeholder="" min="0">
                        </div>
                        <label> 以上 </label>
                        <div class="form-group">
                            <input type="number" name="price_to" value="<?= set_value('price_to'); ?>" class="form-control" id="price_to" placeholder="" min="0">
                        </div>
						<label> 以下 </label>
                    </div>
                    <div class="form-group form-inline">
                        <label>在庫</label>
                        <div class="form-group">
                            <input type="number" name="stock_from" value="<?= set_value('stock_from'); ?>" class="form-control" id="stock_from" placeholder="" min="0">
                        </div>
                        <label> 以上 </label>
                        <div class="form-group">
                            <input type="number" name="stock_to" value="<?= set_value('stock_to'); ?>" class="form-control" id="stock_to" placeholder="" min="0">
                        </div>
						<label> 以下 </label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="検索" />
                    </div>
                    <?= form_close() ?>
                </div>
				
				<div class="panel-heading" data-original-title="">
                    <h3 class="panel-title">
						<i class="glyphicon glyphicon-list"></i> 検索結果
						<button class="btn btn-warning btn-sm btn-create pull-right" data-id="" style="margin-top:-5px;"><i class="glyphicon glyphicon-plus icon-white"></i> 新規登録</button>
					</h3>
					
                </div>
				<div class="panel-body">
			      <table class="table table-bordered bootstrap-datatable">
                    <thead>
                      <tr>
                        <th>ID</th>
						<th>状態</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫</th>
                        <th nowrap>処理</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($products as $product) : ?>
                        <tr class="<?= $product['deleted_timestamp'] ? 'danger' : ''?>">
							<td class="text-right"><a href="<?= site_url('products/read/'.$product['id'])?>"><?= $product['id'] ?></td>
							<td class="text-center"><?= Products_model::$status_labels[$product['status']] ?></td>
							<td class="text-left"><?= htmlspecialchars($product['name']) ?></td>
							<td class="text-right"><?= number_format($product['price']) ?></td>
							<td class="text-right"><?= number_format($product['stock']) ?></td>
							<td class="text-center">
								<div class="btn-group">
									<button class="btn btn-success btn-sm btn-read" data-id="<?=$product['id']?>"><i class="glyphicon glyphicon-zoom-in icon-white"></i> 詳細</button>
									<button class="btn btn-primary btn-sm btn-update" data-id="<?=$product['id']?>"><i class="glyphicon glyphicon-pencil icon-white"></i> 編集</button>
									<button class="btn btn-warning btn-sm btn-create" data-id="<?=$product['id']?>"><i class="glyphicon glyphicon-plus icon-white"></i> コピー</button>
									<button class="btn btn-danger btn-sm btn-delete" data-id="<?=$product['id']?>"><i class="glyphicon glyphicon-trash icon-white"></i> 削除</button>
								</div>
							</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var url = "<?= site_url('products')?>";
$(document).ready(function(){
    $('.bootstrap-datatable').DataTable({
		"columns": [
			null,
			{ "orderable" : false },
			null,
			null,
			null,
			{ "orderable" : false }
		]
	});
});
$(document).on('click', '.btn-read', function(){
	location.href = url + '/read/' + $(this).data('id');
});
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
