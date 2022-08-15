<?php
ini_set("user_agent", $_SERVER['HTTP_USER_AGENT']);
session_start();

$_SESSION["urlList"] = $_POST['urlList'];
$_SESSION["check_url"] = $_POST['check_url'];
$_SESSION["check_code"] = $_POST['check_code'];
$_SESSION["check_redirect"] = $_POST['check_redirect'];
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
$_SESSION["customText"] = $_POST['customText'];
$_SESSION["customClassText"] = $_POST['customClassText'];


require_once($_SERVER['DOCUMENT_ROOT'] . '/php/template-part/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/php/parse.php');

?>
<h1>История парсинга</h1>
<form action="view.php" method="POST" class="form-history">
    <div class="mb-3">
        <div class="row">
            <div class="col">
                <label for="urlList" class="form-label">Перечень URL</label>
                <textarea class="form-control url_area" name="urlList" id="urlList"><?php echo $_SESSION["urlList"]; ?></textarea>
                <br>
            </div>

            <div class="col">
                <label class="form-check-label" for="check_all">Настройки отображения
                </label><br>
                <input id="check_all" class="form-check-input" type="checkbox">
                <label class="form-check-label" for="check_all">Выбрать все
                </label>
                <div class="row" id="check-all-check">
                    <div class="col">
                        <input id="check_url" name="check_url" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_url"] == 'on') echo 'checked'; ?>>
                        <label class="form-check-label" for="check_url">URL
                        </label><br>
                        <input id="check_code" name="check_code" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_code"] == 'on') echo 'checked'; ?>>
                        <label class="form-check-label" for="check_code">Код ответа
                        </label><br>
                        <input id="check_redirect" name="check_redirect" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_redirect"] == 'on') echo 'checked'; ?>>
                        <label class="form-check-label" for="check_redirect">Редирект
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
                        <label class="form-check-label" for="check_custom_tag">Свой HTML-tag
                        </label><input class="form-control" type="text" id="customText" value="" name="customText">
                        <input id="check_custom_class" name="check_custom_class" class="form-check-input" type="checkbox" <?php if ($_SESSION["check_custom_class"] == 'on') echo 'checked'; ?>>
                        <label class="form-check-label" for="check_custom_class">Cвой Class(.) / ID(#)
                        </label><input class="form-control" type="text" id="customClassText" value="" name="customClassText">

                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">История</button>
            </div>
        </div>
    </div>
</form>