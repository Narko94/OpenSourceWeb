<?php
/**
 * Created by PhpStorm.
 * User: Narko
 * Email: unreal-game@inbox.ru
 * Telegram: @Narko_Dev
 * Date: 13.01.2019
 * Time: 16:18
 */

session_start();
@include('./core/core.php');
@include('./session.php');
if(isset($_GET['lv']))
{
    $work->page();
}
else
{
    ?>
    <!DOCTYPE HTML>
    <html lang="ru">
    <head>
        <title><?php print $work->getTitle(); ?></title>
        <?php
        print $work->getCSS();
        ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <meta http-equiv='Content-Type' content='text/html; Charset=windows-1251'>
        <link rel="shortcut icon" href="./img/favicon.ico">
        <?php
        print $work->getJS();
        ?>
    </head>
    <body>
    <span id="loading" style="display: none;"><div class="loading"><img src="./img/load.gif" /><span>Идет загрузка...</span></div></span>
    <?php
    $work->win('result', 600);
    $work->win('pro', 400);
    ?>
    <div class="header">
        <?php
        $work->getHeader();
        ?>
    </div>
    <div class="content">
        <div class="main_cont">
            <div class="mess" id="mini_profile_1" style="display: none;overflow-y: auto;"></div>
            <?php
            $work->page();
            $login = "Narko";
            $pass = "test";
            $test = sha1(md5(base64_encode($pass).":".base64_encode(strtoupper($login))));
            print_r($test);
            ?>
        </div>
    </div>
    <div class="message" id="message"></div>
    <div class="footer">©2017</div>
    </body>
    </html>
    <?php
}
?>