<html>
<head>
<title>Formulario de Carga</title>
</head>
<body>
<?php echo $error;?>
<?php echo form_open_multipart('importar/do_import'); ?>
<input type="file" name="userfile" size="20" />
<br /><br />
<input class="btn btn-primary btn-primary" type="submit" value="Importar" />
</form>
</body>
</html>