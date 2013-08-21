<link rel="stylesheet" href="<?= base_url() ?>css/TagCloud.css" />
<div>
<h3>Keywords: <?=$totalKeyWords?></h3>
</div>
<div id="tagcloudFull" >
<?php
asort($keys);    
$max_size=3;
$spread=1;
$min_size=1;
$minimum=7;
$max=35;

    foreach ($keys as $v):
        $frecuencia= $v->Frequencia;
        $key=$v->Name;       
        $size = ($min_size + ($frecuencia - $minimum)* ($max_size - $min_size) / $spread) ;
        if ($size>$max )
            $size =$max;
       ?>
       <span >
         <span style="font-size:<?=floor($size)?>px" ><?php echo "$key ($frecuencia)"; ?></a>
       </span>
    <?php  endforeach; ?>
</div>
<div id="result2" name="result2"  style="float:left;width:600px;padding-left: 10px "></div>
