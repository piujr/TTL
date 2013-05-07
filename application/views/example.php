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
            
            <a class="add" href='<?php echo site_url('Management/TTL_Keys')?>'>Keywords</a> |             
            <a href='<?php echo site_url('Management/TTL_KeysPub')?>'>Publicaciones y sus Keywords</a> |
            <a href='<?php echo site_url('Management/TTL_authorPublication')?>'>Autores y publicaciones</a> |
            <a href='<?php echo site_url('Management/TTL_Publications')?>'>Publicaciones</a> |
            <a href='<?php echo site_url('Management/TTL_Organization')?>'>Institutos</a> |
            <a href='<?php echo site_url('Management/TTL_Journal')?>'>Journal</a> |
            <a href='<?php echo site_url('Management/TTL_Conference')?>'>Conference</a> 
            
            <?
           $metodos=(get_class_methods("Management"));
           foreach ($metodos as $m ):               
               $pos= strpos($m, 'TTL') ;
               if ($pos !== FALSE){                   
                    ?>
                    <a href='<?php echo site_url('Management/'. $m)?>'><?=substr($m, 4)?></a> |
                <?}
          endforeach;?>		
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
