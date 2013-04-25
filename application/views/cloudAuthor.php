<link rel="stylesheet" href="<?= base_url() ?>css/TagCloud.css" />
<div>
<h2><?=$nombreAuthor?></h2>
<h3>Keywords: <?=$totalKeyWords?></h3>
</div>
<div id="tagcloud" style="float:left;width:300px;  padding-right: 30px">
<?php
asort($keys);    
    foreach ($keys as $v):
        $frecuencia= $v->Frequencia;
        $key=$v->Name;
       $idKey=$v->idKeyword;       
        $size = ($min_size*2 + ($frecuencia - $minimum)* ($max_size - $min_size) / $spread) ;
       ?>
       <span >
         <span style="font-size:<?=floor($size)?>px" ><?php echo $key; ?></a>
       </span>
    <?php  endforeach; ?>
</div>
<div id="result2" name="result2"  style="float:left;width:600px;padding-left: 10px "></div>
