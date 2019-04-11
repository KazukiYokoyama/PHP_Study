<div class="container">
	<div class="text-center">
		<h1>記事一覧</h1>
		<p>
			<form method="POST">
			<input type="button" value="新規作成" onclick="./user/articles_edit">
				<div class="form-group">
					<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
						<?= $this->getData('articlelist'); ?>
					</table>
				</div>
			</form>
		</p>
	</div>

</div>