<!DOCTYPE html>
<html lang="en">

<head>
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
	<main class="main">

		<div class="content">
			<h1>Write new Article</h1>

			<form action="" method="POST">
				<div>
					<label for="title">Title*</label>
					<input type="text" name="title" class="<?= form_error('title') ? 'invalid' : '' ?>" placeholder="Judul artikel" value="<?= set_value('title') ?>" required maxlength="128" />
					<div class="invalid-feedback">
						<?= form_error('title') ?>
					</div>
				</div>

				<div>
					<label for="content">Konten</label>
					<textarea id="editor" name="content" cols="30" rows="10" placeholder="Tuliskan isi pikiranmu..."><?= set_value('content') ?></textarea>
				</div>

				<div>
					<button type="submit" name="draft" class="button" value="true">Save to Draft</button>
					<button type="submit" name="draft" class="button button-primary" value="false">Publish</button>
					<div class="invalid-feedback">
						<?= form_error('draft') ?>
					</div>
				</div>
			</form>

			<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
			<script>
				var quill = new Quill('#editor', {
					theme: 'snow'
				});
			</script>
		</div>
	</main>
</body>

</html>