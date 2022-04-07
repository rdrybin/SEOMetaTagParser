<?php
//function parse url list and genetate array with parsed data
function parseData ($urlList ,$tagArray){ 

    function getCodeRespAndRedirect($headers){
        if (empty($headers)) {
            $code = 'noResponse';
        } else {
            $code = substr($headers[0], 9, 3);
        }
        if ($code == "301"){
            $redir = $headers[6];
        }
        return $array = [
            "code" => $code,
            "redirectPath" => $redir,
        ];
    }

    $links = explode ("\n" ,$urlList);
    $resArray=[];
    $i = 0;
    foreach ($links as $link) {
        $link =trim($link);
        
        if($tagArray['link']["url"] == "true" && $tagArray['link']["rCode"] == "true"){
            $codeRedirect = getCodeRespAndRedirect(get_headers($link));
            $resArray[$i]['link'] = $link;
            $resArray[$i]['code'] = '<b>Code:'. $codeRedirect["code"]."</b><br>".$codeRedirect['redirectPath'];
            
        }elseif($tagArray['link']["url"] == "true"){
            $resArray[$i]['link'] = $link;
        }else{

        }

        if ($tagArray['tags'] && filter_var($link, FILTER_VALIDATE_URL)){
            $html = new simple_html_dom();
            $html->load_file($link); 
            $j = 0;
            foreach($tagArray['tags'] as $tag) { 
                $parseResult  = $html->find($tag);
                $z=0;
                $resArray[$i][(array_keys($tagArray['tags'])[$j])][0]='';
                foreach ($parseResult as $dataElement) {
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])][$z] = strip_tags($dataElement->innertext).strip_tags($dataElement->content).strip_tags($dataElement->href)."";
                    $z++;
                }
                $j++;
            }
                
            
        }elseif($tagArray['tags']){
            $j = 0;
            
            foreach($tagArray['tags'] as $tag){
                if ($tag == 'true'){
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])] = '<b>Code:' .'</b> '. $link ;
                }else{
                    $z=0;
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])][0]='code: '.' ОШИБКА! Проверьте URL!';
                }
                $j++;
            }   
        
        }
        $i++;
    }
   generateTable($resArray);

}


//function generates a table with parsing results
function generateTable($resArray){
        
    function generateTableHead($tagArray){
        echo '<thead><tr>';        
        foreach (array_keys($tagArray[0]) as $tag){
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
    generateTableHead($resArray);
    generateTableBody($resArray);
    echo '</table>';
}