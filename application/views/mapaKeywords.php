<link type="text/css" href="<?= base_url() ?>css/graph.css" rel="stylesheet" />
<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/jit/jit.js"></script>
<script language="javascript" type="text/javascript" >
    var json=<?=  json_encode($json)?>;
</script>
<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/keysGraph.js"></script>

<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/multiselect/jquery.multiselect.filter.js"></script>
<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/multiselect/jquery.multiselect.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jquery.multiselect.filter.css" />
</head>
<?if (!empty($json)){?>
<body onload="init(json);">
<?}?>
<div>
<form style="margin:20px 0" id="Keys" method="POST" action="#">
	
	<p>
		<select name="keys[]" id="keys" multiple="multiple" style="width:370px">
                    <?  foreach ($Keyword as $k):?>
			<option value="<?=$k->idKeyword?>"><?=$k->Name?></option>
                    <?  endforeach;?>
		</select>
	
        <button type="submit">Revisar</button>
        </p>
</form>
    </div>
<div>
  
</div>
    
    <div id="container">


<div id="center-container">
    <div id="infovis"></div>    
</div>

<div id="right-container">

<div id="inner-details"></div>

</div>

<div id="log"></div>
</div>
<script language="javascript" type="text/javascript" >
 $("select").multiselect().multiselectfilter({
    filter: function(event, matches){
        if( !matches.length ){
            // do something
        }
    }
});
</script>
