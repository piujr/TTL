
<form id="form1" name="form1" method="post" action="">
<label for="textfield"></label>
<input type="text" name="textfield" id="textfield" />
<label for="select"></label>
<select name="select" id="select">
<option value="yes">yes</option>
<option value="no">no</option>
</select>
</form>

<form id="form2" name="form2" method="post" action="">
<label for="textfield2"></label>
<input type="text" name="textfield2" id="textfield2" />
<label for="select2"></label>
<select name="select2" id="select2">
<option value="yes">yes</option>
<option value="no">no</option>
</select>
</form>

<script>
$(':input').change(function() {
        alert('Handler for .change() called.');
        }); 
</script>
