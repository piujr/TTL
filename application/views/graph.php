<link type="text/css" href="<?= base_url() ?>css/graph.css" rel="stylesheet" />

<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/jit/jit.js"></script>
<script language="javascript" type="text/javascript" >
    var json=<?=  json_encode($json)?>;
</script>

<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/example1.js"></script>
</head>

<body onload="init(json);">
<div id="container">


<div id="center-container">
    <div id="infovis"></div>    
</div>

<div id="right-container">

<div id="inner-details"></div>

</div>

<div id="log"></div>
</div>
</body>



