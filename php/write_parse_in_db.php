<?php
function writeParseInDB($resArray, $tagArray)
{

    function insertInSiteTable($conn, $site_url)
    {
        $query = "SELECT * FROM site WHERE site_url='$site_url'";
        $result = $conn->query($query);
        $count = $result->num_rows;
        if ($count > 0) {
            $row = $result->fetch_object();
            $row->site_id;
            return $row->site_id;
        } else {
            $query = "INSERT INTO site VALUES" .
                "(NULL, '$site_url')";
            $result = $conn->query($query);
            if (!$result) echo "INSERT failed<br><br>";
            return $conn->insert_id;
        }
    }

    function insertInUrlTable($conn, $link, $site_id)
    {
        $query = "SELECT * FROM url WHERE url_addres='$link'";
        $result = $conn->query($query);
        $count = $result->num_rows;
        if ($count > 0) {
            $row = $result->fetch_object();
            $row->site_id;
            return $row->url_id;
        } else {
            $query = "INSERT INTO url VALUES" .
                "(NULL, $site_id ,'$link')";
            $result = $conn->query($query);
            if (!$result) echo "INSERT failed<br><br>";
            return $conn->insert_id;
        }
    }

    function insertInParseTable($conn, $res, $tagArray, $url_id, $jobNumber)
    {
        if ($conn->connect_error) die("Fatal Error!");
        $stmt = $conn->prepare('INSERT INTO parse_res VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

        $parse_id = NULL;
        $parse_date = date('Y-m-d H:i:s');
        $title = $res['title'][0];
        $description = $res['description'][0];
        $keywords = $res['keywords'][0];
        $h1 = json_encode($res['h1']);
        $h2 = json_encode($res['h2']);
        $h3 = json_encode($res['h3']);
        $h4 = json_encode($res['h4']);
        $h5 = json_encode($res['h5']);
        $h6 = json_encode($res['h6']);
        $custom_tag = $tagArray['tags']['custom'];
        $custom_tag_res = json_encode($res['custom']);
        $custom_class = $tagArray['tags']['customClass'];
        $custom_class_res = json_encode($res['customClass']);
        $res_code = $res['code'][0];
        $job_id = $jobNumber;
        $redirect_addres = $res['code'][1];

        $stmt->bind_param(
            'isissssssssssssssis',
            $parse_id,
            $parse_date,
            $url_id,
            $title,
            $description,
            $keywords,
            $h1,
            $h2,
            $h3,
            $h4,
            $h5,
            $h6,
            $custom_tag,
            $custom_tag_res,
            $custom_class,
            $custom_class_res,
            $res_code,
            $job_id,
            $redirect_addres
        );
        $stmt->execute();
        $stmt->close();
    }

    function insertInJobTable($conn)
    {
        $dateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO job VALUES" .
            "(NULL, '$dateTime')";
        $result = $conn->query($query);
        if (!$result) echo "INSERT failed<br><br>";
        return $conn->insert_id;
    }

    require_once 'php\sql_conn.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    $jobNumber = insertInJobTable($conn);
    foreach ($resArray as $res) {
        $link = $res['link'];
        $site_url = parse_url($link, PHP_URL_HOST);
        $site_id = insertInSiteTable($conn, $site_url);
        $url_id = insertInUrlTable($conn, $link, $site_id);
        insertInParseTable($conn, $res, $tagArray, $url_id, $jobNumber);
    }
    $conn->close();
    return $jobNumber;
}
