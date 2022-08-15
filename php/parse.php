<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//function parse url list and genetate array with parsed data
function parseData($urlList, $tagArray)
{
    require_once('SimpleDomHTMLParser/simple_html_dom.php');
    require_once('URLPunicode.php');

    $links = explode("\n", $urlList);
    $resArray = [];
    $i = 0;
    foreach ($links as $link) {
        $link = trim($link);
        $punicode = new URLPunicode();
        if (preg_match('+(xn--).+', $link)) {
            
            $link = $punicode->punycode_decodeURL($link);
            $punicodedLink = $link;
        } else {
            $punicodedLink = $punicode->punycode_encodeURL($link);
        }
        echo  $punicodedLink. $link;
        if ($tagArray['link']["url"] == "true" && $tagArray['link']["rCode"] == "true") {
            $codeRedirect = getCodeRespAndRedirect(get_headers($punicodedLink));
            $resArray[$i]['link'] = $link;
            $resArray[$i]['code'][0] = $codeRedirect["code"];
            $resArray[$i]['code'][1] =  $codeRedirect['redirectPath'];
        } elseif ($tagArray['link']["url"] == "true") {
            $resArray[$i]['link'] = $link;
        } else {
        }

        if ($tagArray['tags'] && filter_var($punicodedLink, FILTER_VALIDATE_URL) && !preg_match("((4|5)[0-9]{2}|302|000)", $codeRedirect['code'])) {
            $html = new simple_html_dom();

            $html->load_file($punicodedLink);
            $j = 0;
            foreach ($tagArray['tags'] as $tag) {
                $parseResult  = $html->find($tag);
                $z = 0;
                $resArray[$i][(array_keys($tagArray['tags'])[$j])][0] = '';
                foreach ($parseResult as $dataElement) {
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])][$z] = strip_tags($dataElement->innertext) . strip_tags($dataElement->content) . strip_tags($dataElement->href) . "";
                    $z++;
                }
                $j++;
            }
        } elseif ($tagArray['tags']) {
            $j = 0;

            foreach ($tagArray['tags'] as $tag) {
                if ($tag == 'true') {
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])] = '<b>Code:' . '</b> ' . $link;
                } else {
                    $z = 0;
                    $resArray[$i][(array_keys($tagArray['tags'])[$j])][0] = 'code: ' . ' не парсится';
                }
                $j++;
            }
        }
        $i++;
    }
    require_once 'write_parse_in_db.php';
    echo '<h2>Номер задания: ' . writeParseInDB($resArray, $tagArray) . '</h2>';
    generateTable($resArray);
}
//проверяет код ответа и адрес редиректа
function getCodeRespAndRedirect($headers)
{
    if (empty($headers)) {
        $code = '000';
    } else {
        $code = substr($headers[0], 9, 3);
    }
    if ($code == "301") {
        $redir = $headers[6];
    }
    return $array = [
        "code" => $code,
        "redirectPath" => $redir,
    ];
}


//function generates a table with parsing results
function generateTable($resArray)
{

    function generateTableHead($tagArray)
    {
        echo '<thead><tr>';
        foreach (array_keys($tagArray[0]) as $tag) {
            echo "<th>$tag</th>";
        }
        echo '</tr></thead>';
    }

    function generateTableBody($resArray)
    {
        foreach ($resArray as $res) {
            echo '<tr>';
            foreach ($res as $cell) {
                echo '<td>';
                if (is_array($cell)) {
                    foreach ($cell as $dataElement) {
                        echo $dataElement . "<br>\r\n";
                    }
                } else {
                    echo $cell . "<br>\r\n";
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
