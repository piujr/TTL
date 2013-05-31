<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>

<body>
	<div>
            
            
            <a class="add" href='<?php echo site_url('authors/add')?>'>Agregar Investigadores</a> |             
            <a class="add" href='<?php echo site_url('Management/TTL_Keyword')?>'>Keywords</a> |             
            <a href='<?php echo site_url('Management/TTL_KeysPub')?>'>Publicaciones y sus Keywords</a> |
            <a href='<?php echo site_url('Management/TTL_authorPublication')?>'>Autores y publicaciones</a> |
            <a href='<?php echo site_url('Management/TTL_Publication')?>'>Publicaciones</a> |
            <a href='<?php echo site_url('Management/TTL_Organization')?>'>Institutos</a> |
            <a href='<?php echo site_url('Management/TTL_Journal')?>'>Journal</a> |
            <a href='<?php echo site_url('Management/TTL_Conference')?>'>Conference</a> 
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
