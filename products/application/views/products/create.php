<div id="content" class="col-lg-12 col-sm-12">
    <ul class="breadcrumb">
		<li><a href="<?= site_url('products') ?>">検索</a></li>
		<li class="active">新規登録<?= $id ? ' コピー元 [ID:'.$id.']' : ''?></li>
	</ul>
	<?php $this->load->view('common/messages')?>
	<div class="row">
		<div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading" data-original-title="">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-plus"></i> <?= $id ? 'コピーして登録' : '新規登録'?></h3>
                </div>
				<div class="panel-body">
					<?= form_open('products/create/' . $id); ?>
					<div class="form-group">
						<label for="name">商品名</label>
						<input type="text" name="name" value="<?= set_value('name', $product['name']); ?>" class="form-control" id="name" placeholder="" required>
					</div>
					<div class="form-group">
						<label for="status">状態</label>
						<label class="radio-inline">
							<input type="radio" name="status" id="status_1" value="1" <?= set_radio('status', '1', $product['status'] == 1); ?>> 有効
						</label>
						<label class="radio-inline">
							<input type="radio" name="status" id="status_0" value="0" <?= set_radio('status', '0', $product['status'] == 0); ?>> 無効
						</label>
					</div>
					<div class="form-group">
						<label for="price">価格</label>
						<input type="number" name="price" value="<?= set_value('price', $product['price']); ?>" min="0" class="form-control" id="price" placeholder="" required>
					</div>
					<div class="form-group">
						<label for="price">在庫数</label>
						<input type="number" name="stock" value="<?= set_value('stock', $product['stock']); ?>" min="0" class="form-control" id="stock" placeholder="" required>
					</div>
					<div class="form-group">
			            <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-plus icon-white"></i> 登録</button>
					</div>
					<?= form_close()?>
				</div>
			</div>
		</div>
    </div>
</div>
