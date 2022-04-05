<?php

function parseData ($urlList ,$tagArray){
    $links = explode ("\n" ,$urlList);
    $resArray=[];
    $i = 0;
    foreach ($links as $link) {
        $headers = get_headers(trim($link));
        if (empty($headers[0])) {
            $code = 'noResponse';
        } else {
            $code = substr($headers[0], 9, 3);
        }
/*        echo "<pre>";
        print_r($links);

        echo '<br>'.$link.'<br>';
        print_r($headers);
        echo "</pre>";*/
        if (filter_var(trim($link), FILTER_VALIDATE_URL) && $code != '404' && $code != 'noResponse'){
            $html = new simple_html_dom();
            $html->load_file(trim($link)); 
            $j = 0;
            foreach($tagArray as $tag){
                if ($tag == 'true'){
                    $resArray[$i][(array_keys($tagArray)[$j])] = '<b>Code:'. $code.'</b> '.$link;
                }else{
                    $parseResult  = $html->find($tag);
                    $z=0;
                    $resArray[$i][(array_keys($tagArray)[$j])][0]='';
                    foreach ($parseResult as $dataElement) {
                        $resArray[$i][(array_keys($tagArray)[$j])][$z] = strip_tags($dataElement->innertext).strip_tags($dataElement->content).strip_tags($dataElement->href)."";
                        $z++;
                    }
                }
                $j++;
            }
        }else{
            $j = 0;
            foreach($tagArray as $tag){
                if ($tag == 'true'){
                    $resArray[$i][(array_keys($tagArray)[$j])] = '<b>Code:'. $code.'</b> '.$link;
                }else{
                    $z=0;
                    $resArray[$i][(array_keys($tagArray)[$j])][0]='code: '.$code.' ОШИБКА! Проверьте URL!';
                }
                $j++;
            }   
        
        }
        $i++;
    }
    generateTable($resArray ,$tagArray);
}

function generateTable($resArray ,$tagArray){
        
    function generateTableHead($tagArray){
        echo '<thead><tr>';
        foreach (array_keys($tagArray) as $tag){
            echo "<th>$tag</th>";
        }
        echo '</tr></thead>';
    }

    function generateTableBody($resArray){
        foreach($resArray as $res){
            echo '<tr>';

                foreach($res as $cell){
                    echo '<td>';
                    if (is_array($cell)){
                        foreach ($cell as $dataElement) {
                            echo $dataElement. "<br>\r\n";
                        }
                    }else{
                        echo $cell. "<br>\r\n";
                    }
                    echo '</td>';
                }
            echo '</tr>';
        }
    }
    echo '<table class="table table-striped">';
    generateTableHead($tagArray);
    generateTableBody($resArray);
    echo '</table>';
}