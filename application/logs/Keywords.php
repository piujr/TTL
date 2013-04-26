<?php
/*
UPDATE
  Keyword
SET
  baja = 2
WHERE
  idKeyword IN (
 654,1243,2606,3469,3520,3753,5412,6752,6848,7138,7575,7597,8066,8719,8799,9739,10134,10364,10508,10968,11155,11468,11552,11757,11828,12111,12408,12421,13430,13583,14080,14491,14618,15200,15821,16007,17347,18300,18640,19152,19424,19641,19969,20686,21217,21525,22985,23180,23592,23701,23863,26538,26689,27761,28192,28258,28374,29734,30156,30488,30897,31798,32161,33468,34738,35093,35160,35174,35437,35895,36011,36038,36248,36378,36554,36676,37937,37958,38375,38916,39150,39205,39277,39433,40471,40577,40612,40616,40655,41528,41751,41787,42090,42094,43177,44359,44419,44484,44505,44833,44888,45289,45303,45326,53693,57822,58158,60527,67407,68671,72370
  )
 * 
 */

// query para saber que keys solo pertenecen a 1 o t autores
        
/*
SELECT 
  Publication_has_Keyword.Keyword_idKeyword,
  count(Author_has_Publication.Author_IDAuthor) AS t
FROM
  Keyword
  INNER JOIN Publication_has_Keyword ON (Keyword.idKeyword = Publication_has_Keyword.Keyword_idKeyword)
  INNER JOIN Publication ON (Publication_has_Keyword.Publication_idPublication = Publication.idPublication)
  INNER JOIN Author_has_Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
GROUP BY
  Publication_has_Keyword.Keyword_idKeyword
HAVING
t = 1
 * 
 */


        
?>
