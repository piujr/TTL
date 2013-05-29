
<a class="add" href='<?php echo site_url('authors/add')?>'>Agregar Investigadores</a> |             
<a class="add" href='<?php echo site_url('Management/TTL_Keys')?>'>Keywords</a> |             
<a href='<?php echo site_url('Management/TTL_KeysPub')?>'>Publicaciones y sus Keywords</a> |
<a href='<?php echo site_url('Management/TTL_authorPublication')?>'>Autores y publicaciones</a> |
<a href='<?php echo site_url('Management/TTL_Publications')?>'>Publicaciones</a> |
<a href='<?php echo site_url('Management/TTL_Organization')?>'>Institutos</a> |
<a href='<?php echo site_url('Management/TTL_Journal')?>'>Journal</a> |
<a href='<?php echo site_url('Management/TTL_Conference')?>'>Conference</a> 
<br>
<br>
<br>
<br>
<form action="add" method="post"> 
    Id Microsoft<input type="text" name="IDM">
    <input type="submit" value="Registrar">    
</form>
<pre>
<?print_r($res)?>
</pre>