<?php
session_start();

$_SESSION["site_dropdown"] = $_POST['site_dropdown'];
$_SESSION["url_dropdown"] = $_POST['url_dropdown'];
$_SESSION["job_date"] = $_POST['job_date'];
$_SESSION["job_dropdown"] = $_POST['job_dropdown'];
$_SESSION["check_filter_date"] = $_POST['check_filter_date'];
$_SESSION["start_date"] = $_POST['start_date'];
$_SESSION["end_date"] = $_POST['end_date'];
$_SESSION["check_url"] = $_POST['check_url'];
$_SESSION["check_code"] = $_POST['check_code'];
$_SESSION["check_date"] = $_POST['check_date'];
$_SESSION["check_titlte"] = $_POST['check_titlte'];
$_SESSION["check_description"] = $_POST['check_description'];
$_SESSION["check_keywords"] = $_POST['check_keywords'];
$_SESSION["check_h1"] = $_POST['check_h1'];
$_SESSION["check_h2"] = $_POST['check_h2'];
$_SESSION["check_h3"] = $_POST['check_h3'];
$_SESSION["check_h4"] = $_POST['check_h4'];
$_SESSION["check_h5"] = $_POST['check_h5'];
$_SESSION["check_h6"] = $_POST['check_h6'];
$_SESSION["check_custom_tag"] = $_POST['check_custom_tag'];
$_SESSION["check_custom_class"] = $_POST['check_custom_class'];
$_SESSION["check_jobnum"] = $_POST['check_jobnum'];


require_once 'php\sql_conn.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/php/template-part/header.php');
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");
?>

<container class="container-fluid">
  <h1>История парсинга</h1>
  <form action="view.php" method="POST" class="form-history">
    <div class="mb-3">
      <div class="row">
        <div class="col">
          <label for="site_dropdown" class="form-label"></label>
          <?php generateSiteDropDown($conn); ?>
          <?php generateJobDropDown($conn); ?>

          <br>
        </div>

        <div class="col">
          <div class="form-check">
            <input id="check_filter_date" name="check_filter_date" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_filter_date"] == 'on') echo 'checked'; ?> onclick="checkFluency()">
            <label class="form-check-label" for="check_filter_date">
              Фильтровать по дате
            </label>
          </div>
          <label for="start_date">Начало периода</label>
          <input id="start_date" name="start_date" class="form-control" type="date" disabled value="<?php echo $_SESSION["start_date"]; ?>" />
          <label for="end_date">Конец периода</label>
          <input id="end_date" name="end_date" class="form-control" type="date" disabled value="<?php echo $_SESSION["end_date"]; ?>" />
        </div>

        <div class="col">
          <label for="sort">Сортировка</label>
          <?php generateSortDropDown(); ?>
          <input id="check_all" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="check_all">Выбрать все
          </label>
          <div class="row" id="check-all-check">
            <div class="col">
              <input id="check_url" name="check_url" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_url"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_url">URL
              </label><br>
              <input id="check_code" name="check_code" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_code"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_code">Code
              </label><br>
              <input id="check_date" name="check_date" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_date"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_date">Дата
              </label><br>
              <input id="check_titlte" name="check_titlte" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_titlte"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_titlte">Titlte
              </label><br>
              <input id="check_description" name="check_description" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_description"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_description">Description
              </label><br>
              <input id="check_keywords" name="check_keywords" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_keywords"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_keywords">Keywords
              </label><br>
            </div>

            <div class="col">
              <input id="check_h1" name="check_h1" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h1"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h1">h1
              </label><br>
              <input id="check_h2" name="check_h2" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h2"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h2">h2
              </label><br>
              <input id="check_h3" name="check_h3" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h3"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h3">h3
              </label><br>
              <input id="check_h4" name="check_h4" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h4"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h4">h4
              </label><br>
              <input id="check_h5" name="check_h5" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h5"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h5">h5
              </label><br>
              <input id="check_h6" name="check_h6" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_h6"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_h6">h6
              </label><br>
            </div>

            <div class="col">
              <input id="check_custom_tag" name="check_custom_tag" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_custom_tag"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_custom_tag">Cus. tag
              </label><br>
              <input id="check_custom_class" name="check_custom_class" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_custom_class"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_custom_class">Cus. class/id
              </label><br>
              <input id="check_jobnum" name="check_jobnum" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_jobnum"] == 'on') echo 'checked'; ?>>
              <label class="form-check-label" for="check_jobnum">№ задания
              </label><br>
            </div>

          </div>

        </div>
      </div>
      <button type="submit" class="btn btn-primary">История</button>
    </div>
  </form>

  <script>
    var checkbox = document.getElementById('check_filter_date');
    if (checkbox.checked != true) {
      document.getElementById("start_date").disabled = true;
      document.getElementById("end_date").disabled = true;
    } else {
      document.getElementById("start_date").disabled = false;
      document.getElementById("end_date").disabled = false;
    }

    function checkFluency() {
      var checkbox = document.getElementById('check_filter_date');
      if (checkbox.checked != true) {
        document.getElementById("start_date").disabled = true;
        document.getElementById("end_date").disabled = true;
      } else {
        document.getElementById("start_date").disabled = false;
        document.getElementById("end_date").disabled = false;
      }
    }
    let inputs = document.getElementById('check-all-check').getElementsByTagName('input');
    document.getElementById('check_all').addEventListener('click', function checkme(e, check) {
      check = check === undefined ? false : true;
      for (var i = 0, inputs_len = inputs.length; i < inputs_len; i++) {
        if (!check && !inputs[i].checked) {
          checkme(e, true);
          return;
        }
        inputs[i].checked = check;
      }
    });
  </script>

  <?php
  //print_r($_POST);


  if (isset($_POST['site_dropdown'])) {
    $recArray = generateArrPrintableData();
    $query = generateFilterSortQuerry($recArray);
    //echo $query;
    printResultTable($conn->query($query), $recArray);



    $conn->close();
  }

  function generateArrPrintableData()
  {
    $baseArr = [
      'check_url' => ['url.url_addres', 'URL', 's'],
      'check_code' => ['parse_res.res_code', 'Код ответа', 's'],
      'check_date' => ['parse_res.parse_date', 'Дата', 's'],
      'check_titlte' => ['parse_res.title', 'Title', 's'],
      'check_description' => ['parse_res.description', 'Description', 's'],
      'check_keywords' => ['parse_res.keywords', 'Keywords', 's'],
      'check_h1' => ['parse_res.h1', 'h1', 'j'],
      'check_h2' => ['parse_res.h2', 'h2', 'j'],
      'check_h3' => ['parse_res.h3', 'h3', 'j'],
      'check_h4' => ['parse_res.h4', 'h4', 'j'],
      'check_h5' => ['parse_res.h5', 'h5', 'j'],
      'check_h6' => ['parse_res.h6', 'h6', 'j'],
      'check_custom_tag' => ['parse_res.custom_tag', 'Custom tag', 's'],
      'check_custom_tag_res' => ['parse_res.custom_tag_res', 'Custom tag data', 'j'],
      'check_custom_class' => ['parse_res.custom_class', 'Custom .|#', 's'],
      'check_custom_class_res' => ['parse_res.custom_class_res', 'Custom .|# data', 'j'],
      'check_jobnum' => ['job.job_id', '№ задачи', 's'],
      'check_jobdate' => ['job.job_date', 'Дата задачи', 's'],
    ];

    $recArray = [];

    if ($_POST['check_url'] == 'on') {
      array_push($recArray, $baseArr['check_url']);
    }
    if ($_POST['check_code'] == 'on') {
      array_push($recArray, $baseArr['check_code']);
    }
    if ($_POST['check_date'] == 'on') {
      array_push($recArray, $baseArr['check_date']);
    }
    if ($_POST['check_titlte'] == 'on') {
      array_push($recArray, $baseArr['check_titlte']);
    }
    if ($_POST['check_description'] == 'on') {
      array_push($recArray, $baseArr['check_description']);
    }
    if ($_POST['check_keywords'] == 'on') {
      array_push($recArray, $baseArr['check_keywords']);
    }
    if ($_POST['check_h1'] == 'on') {
      array_push($recArray, $baseArr['check_h1']);
    }
    if ($_POST['check_h2'] == 'on') {
      array_push($recArray, $baseArr['check_h2']);
    }
    if ($_POST['check_h3'] == 'on') {
      array_push($recArray, $baseArr['check_h3']);
    }
    if ($_POST['check_h4'] == 'on') {
      array_push($recArray, $baseArr['check_h4']);
    }
    if ($_POST['check_h5'] == 'on') {
      array_push($recArray, $baseArr['check_h5']);
    }
    if ($_POST['check_h6'] == 'on') {
      array_push($recArray, $baseArr['check_h6']);
    }
    if ($_POST['check_custom_tag'] == 'on') {
      array_push($recArray, $baseArr['check_custom_tag']);
      array_push($recArray, $baseArr['check_custom_tag_res']);
    }
    if ($_POST['check_custom_class'] == 'on') {
      array_push($recArray, $baseArr['check_custom_class']);
      array_push($recArray, $baseArr['check_custom_class_res']);
    }
    if ($_POST['check_jobnum'] == 'on') {
      array_push($recArray, $baseArr['check_jobnum']);
      array_push($recArray, $baseArr['check_jobdate']);
    }

    return $recArray;
  }

  function generateFilterSortQuerry($recArray)
  {
    $reqTabs = [];
    foreach ($recArray as $element) {
      array_push($reqTabs, $element[0]);
    }

    $reqTabs = implode(", ", $reqTabs);
    $whereArr = [];
    $query = "SELECT $reqTabs 
              FROM site
              JOIN url
                ON site.site_id = url.site_id 
              JOIN parse_res
                ON parse_res.url_id= url.url_id
              JOIN job
                ON parse_res.job_id = job.job_id";
    if ($_POST['site_dropdown'] != 0 && $_POST['site_dropdown'] != NULL) {
      array_push($whereArr, "site.site_id ='" . $_POST['site_dropdown'] . "'");
    }
    if ($_POST['url_dropdown'] != 0 && $_POST['url_dropdown'] != NULL) {
      array_push($whereArr, "url.url_id ='" . $_POST['url_dropdown'] . "'");
    }
    if ($_POST['job_dropdown'] != 0 && $_POST['job_dropdown'] != NULL) {
      array_push($whereArr, "job.job_id ='" . $_POST['job_dropdown'] . "'");
    }
    if ($_POST['check_filter_date'] == 'on') {
      array_push($whereArr, "DATE(parse_res.parse_date)  BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "'");
    }
    if (count($whereArr) > 0) $query .= ' WHERE ' . implode(" AND ", $whereArr);
    $sort = "";
    switch ($_POST['sort']) {
      case 0:
        $sort = "";
        break;
      case 1:
        $sort = "ORDER BY parse_res.parse_date DESC";
        break;
      case 2:
        $sort = "ORDER BY parse_res.parse_date";
        break;
      case 3:
        $sort = "ORDER BY url.url_addres DESC";
        break;
      case 4:
        $sort = "ORDER BY url.url_addres ASC";
        break;
    }

    $query .= " " . $sort;
    return $query;
  }

  //выводит таблицу с результатами парсинга
  function printResultTable($result, $recArray)
  {
    echo '<table class="table table-striped" style="font-size: 14px;"><tr>';
    foreach ($recArray as $elem) {
      echo '<th>' . $elem[1] . '</th>';
    }
    echo '</tr></thead>';
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      $i = 0;
      foreach ($row as $cel) {
        if ($recArray[$i][2] == 'j') {
          printTd(decodeAndPrintArr($cel));
        } else {
          printTd($cel);
        }
        $i++;
      }
      echo '</tr>';
    }
    echo "</table>";
  }
  function printTd($string)
  {
    echo '<td><div>' . $string . '</div></td>';
  }

  //функция вывода массива построчно
  function decodeAndPrintArr($arr)
  {
    $arr = json_decode($arr, true);
    $result = "";
    if (is_array($arr)) {
      foreach ($arr as $row) {
        $result .= $row . "<br>";
      }
    }
    return $result;
  }
  //делаем выпадающий список со списком сайтов
  function generateSiteDropDown($conn)
  {
    $selectedSite = $_SESSION["site_dropdown"];
    $query = "SELECT * FROM site";
    $result = $conn->query($query);
    echo '<label for="site_dropdown">Сайт</label>';
    echo '<select class="form-select" id="site_dropdown" name="site_dropdown">';
    echo '<option value="' . "0" . '">' . 'Все' . '</option>';
    while ($row = $result->fetch_assoc()) {
      $countUrl = " в БД ссылкок|парсов (" . getCountUrl($conn, $row['site_id']) . "|" . getCountParses($conn, $row['site_id']) . ")";
      if ($row['site_id'] == $selectedSite) {
        echo '<option value="' . $row['site_id'] . '"selected="selected">' . $row['site_url'] . $countUrl . '</option>';
      } else {
        echo '<option value="' . $row['site_id'] . '">' . $row['site_url'] . $countUrl . '</option>';
      }
    }
    echo '</select>';
    echo '<label for="url_dropdown">Страница</label>';
    echo '<select class="form-select" id="url_dropdown" name="url_dropdown">';
    if ($selectedSite) {
      $query = "SELECT  url_id, url_addres FROM url 
                WHERE site_id = $selectedSite";
      $result = $conn->query($query);

      echo '<option value="' . "0" . '">' . 'Все' . '</option>';
      while ($row = $result->fetch_assoc()) {
        if ($row['url_id'] == $_SESSION["url_dropdown"]) {
          echo '<option value="' . $row['url_id'] . '"selected="selected">' . $row['url_addres'] . '</option>';
        } else {
          echo '<option value="' . $row['url_id'] . '">' . $row['url_addres'] . '</option>';
        }
      }
    }
    echo '</select>';
  }
  function generateJobDropDown($conn)
  {

    echo '<label for="job_date">Дата задания</label>';
    echo '<input id="job_date" name="job_date" class="form-control" type="date" value="' . $_SESSION["job_date"] . '" />';
    $selectedSite = $_SESSION["job_dropdown"];
    $query = "SELECT * FROM job";
    if ($_POST['job_date']) $query .= " WHERE DATE(job_date)  BETWEEN '" . $_POST['job_date'] . "' AND '" . $_POST['job_date'] . "'";
    $result = $conn->query($query);
    echo '<label for="job_dropdown">Задание</label>';
    echo '<select class="form-select" id="job_dropdown" name="job_dropdown" >';
    echo '<option value="' . "0" . '">' . 'Все' . '</option>';
    while ($row = $result->fetch_assoc()) {

      if ($row['job_id'] == $selectedSite) {
        echo '<option value="' . $row['job_id'] . '"selected="selected">' . $row['job_id'] . '(' . $row['job_date'] . ')</option>';
      } else {
        echo '<option value="' . $row['job_id'] . '">' . $row['job_id'] . '(' . $row['job_date'] . ')</option>';
      }
    }
    echo '</select>';
  }
  // генерирует выпадающий список сортировок
  function generateSortDropDown()
  {
    echo '<select class="form-select" id="sort" name="sort">';
    $arr = [
      "0" => "Поумолчанию",
      "1" => "Дата по убыванию",
      "2" => "Дата по возрастанию",
      "3" => "URL по убыванию",
      "4" => "URL по возрастанию",
    ];
    foreach ($arr as $key => $item) {
      if ($key == $_SESSION["sort"]) {
        echo '<option value="' . $key . '"selected="selected">' .  $item . '</option>';
      } else {
        echo '<option value="' . $key . '">' .  $item . '</option>';
      }
    }
    echo '</select>';
  }
  // получает количество url для каждого site
  function getCountUrl($conn, $site_id)
  {
    $query = "SELECT COUNT(url_id)
              FROM site
              JOIN url
                ON site.site_id = url.site_id 
              WHERE site.site_id = $site_id";
    $result = $conn->query($query);
    $row = $result->fetch_row();
    return $row[0];
  }
  // получает количество парсов для каждого site
  function getCountParses($conn, $site_id)
  {
    $query = "SELECT COUNT(parse_res.parse_id)
              FROM site
              JOIN url
                ON site.site_id = url.site_id 
              JOIN parse_res 
                ON url.url_id = parse_res.url_id
                WHERE site.site_id = $site_id";
    $result = $conn->query($query);
    $row = $result->fetch_row();
    return $row[0];
  }
