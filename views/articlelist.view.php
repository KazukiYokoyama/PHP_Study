<div class="container">
	<div class="text-center">
		<h1>記事一覧</h1>
		<p>
			<form method="POST">
			<button type="button" onclick="location.href='./user/articles_edit'">新規作成</button>
				<div class="form-group">
					<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
						<?= $this->getData('articlelist'); ?>
					</table>
				</div>
			</form>
		</p>
	</div>

</div>