<?php
if($_SESSION['mode'] == 2 && $_SESSION['qrsk'] == 1)
{
    $lg = $_SESSION["user"];
    $cha = session_id();
    setcookie("mode", 2, time() + (3600 * 24 * 30));
    setcookie("user", $lg, time() + (3600 * 24 * 30));
    setcookie("cha", $cha, time() + (3600 * 24 * 30));
    setcookie("id", $work->getID(), time() + (3600 * 24 * 30));
    $_SESSION['qrsk'] = null;
}
if($conn->statusQ())
{
    $work->sess_cache();
    $cha = $_COOKIE["cha"];
    $lg = $_COOKIE["user"];
    $id = $_COOKIE["id"];
    if($_COOKIE["mode"] == 2 && $work->cache($id, $cha, 2) == 0)
    {
        foreach($_COOKIE as $ind => $val)
        {
            setcookie($ind, null, time()-1000);
        }
        echo "<script>location.reload();</script>";
    }
}
?>