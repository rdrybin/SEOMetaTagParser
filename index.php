<?php
ini_set("user_agent",$_SERVER['HTTP_USER_AGENT']);
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$_SESSION["urlList"] = $_POST['urlList'];
$_SESSION["url"] = $_POST['url'];
$_SESSION["rCode"] = $_POST['rCode'];
$_SESSION["title"] = $_POST['title'];
$_SESSION["description"] = $_POST['description'];
$_SESSION["keywords"] = $_POST['keywords'];
$_SESSION["h1"] = $_POST['h1'];
$_SESSION["h2"] = $_POST['h2'];
$_SESSION["h3"] = $_POST['h3'];
$_SESSION["h4"] = $_POST['h4'];
$_SESSION["h5"] = $_POST['h5'];
$_SESSION["h6"] = $_POST['h6'];
$_SESSION["custom"] = $_POST['custom'];
$_SESSION["customText"] = $_POST['customText'];
$_SESSION["customClass"] = $_POST['customClass'];
$_SESSION["customClassText"] = $_POST['customClassText'];


require_once($_SERVER['DOCUMENT_ROOT'].'/php/SimpleDomHTMLParser/simple_html_dom.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/parse.php');
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/style.css" >
    <script defer src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <container class="container-fluid">
    <h1>Парсер страниц</h1>
    <form method="POST" class="form">
        Перечень URL<textarea class="form-control url_area" name="urlList"><?php echo $_SESSION["urlList"];?></textarea>
        <div class="properties form-check form-check-inline">
            <div>
                <input class="form-check-input" type="checkbox" id="url" <?php if($_SESSION["url"]=='on') echo 'checked';?> name="url">
                <label for="url">url</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="rCode" <?php if($_SESSION["rCode"]=='on') echo 'checked';?> name="rCode">
                <label for="rCode">Code & redirect</label>
            </div>  
            <div>
                <input class="form-check-input" type="checkbox" id="title" <?php if($_SESSION["title"]=='on') echo 'checked';?> name="title">
                <label for="title">title</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="description" <?php if($_SESSION["description"]=='on') echo 'checked';?> name="description">
                <label for="description">description</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="keywords" <?php if($_SESSION["keywords"]=='on') echo 'checked';?> name="keywords">
                <label for="keywords">keywords</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h1" <?php if($_SESSION["h1"]=='on') echo 'checked';?> name="h1">
                <label for="h1">h1</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h2" <?php if($_SESSION["h2"]=='on') echo 'checked';?> name="h2">
                <label for="h2">h2</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h3" <?php if($_SESSION["h3"]=='on') echo 'checked';?> name="h3">
                <label for="h3">h3</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h4" <?php if($_SESSION["h4"]=='on') echo 'checked';?> name="h4">
                <label for="h4">h4</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h5" <?php if($_SESSION["h5"]=='on') echo 'checked';?> name="h5">
                <label for="h5">h5</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="h6" <?php if($_SESSION["h6"]=='on') echo 'checked';?> name="h6">
                <label for="h6">h6</label>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="custom" <?php if($_SESSION["custom"]=='on') echo 'checked';?> name="custom">
                <label for="custom">Свой HTML-tag</label>
                <input class="form-control" type="text" id="customText" value="<?php echo $_SESSION["customText"];?>" name="customText">
            </div>
            <div>
                <input class="form-check-input" type="checkbox" id="customClass" <?php if($_SESSION["customClass"]=='on') echo 'checked';?> name="customClass">
                <label for="customClass">Cвой Class(.) / ID(#)</label>
                <input class="form-control" type="text" id="customClassText" value="<?php echo $_SESSION["customClassText"];?>" name="customClassText">
            </div>
        </div>
        <br>
    <input type="submit" class="btn btn-primary" value="Парсить!">   
    <br><br>
<?php

if (isset($_POST['urlList'])) {

    $defTag= [
        "title" => "title,Title",
        "description" => 'meta[name=description],meta[name=Description]',
        "keywords" =>  "meta[name=keywords], meta[name=Keywords]",
        "h1" => "h1,H1",
        "h2" => "h3,H2",
        "h3" => "h3,H3",
        "h4" => "h4,H4",
        "h5" => "h5,H5",
        "h6" => "h6,H6",
    ];

    $recArray=[];
    
    if ($_POST['url'] == 'on') {
        $recArray['link']["url"] = "true";
    }
    if ($_POST['rCode'] == 'on') {
        $recArray["link"]['rCode'] = "true";
    }
    if ($_POST['title'] == 'on') {
        $recArray["tags"]["title"] = $defTag['title'];
    }
    if ($_POST['description'] == 'on') {
        $recArray["tags"]["description"] = $defTag['description'];
    }
    if ($_POST['keywords'] == 'on') {
        $recArray["tags"]["keywords"] = $defTag['keywords'];
    }
    if ($_POST['h1'] == 'on') {
        $recArray["tags"]["h1"] = $defTag['h1'];
    }
    if ($_POST['h2'] == 'on') {
        $recArray["tags"]["h2"] = $defTag['h2'];
    }
    if ($_POST['h3'] == 'on') {
        $recArray["tags"]["h3"] = $defTag['h3'];
    }
    if ($_POST["tags"]['h4'] == 'on') {
        $recArray["tags"]["h4"] = $defTag['h4'];
    }
    if ($_POST['h5'] == 'on') {
        $recArray["tags"]["h5"] = $defTag['h5'];
    }
    if ($_POST['h6'] == 'on') {
        $recArray["tags"]["h6"] = $defTag['h6'];
    }
    if ($_POST['custom'] == 'on') {
        $recArray["tags"]["custom"] = $_POST['customText'];
    }
    if ($_POST['customClass'] == 'on') {
        $recArray["tags"]["customClass"] = $_POST['customClassText'];
    }

    echo "<pre>";
    print_r($recArray);
    echo "</pre>";


    parseData($_POST['urlList'], $recArray);
 
} else {
    print 'Нет ссылочек. Как так то?';
    session_destroy();
}
?>
    </container>
</body>