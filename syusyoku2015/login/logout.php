<?php
/**
 * Created by PhpStorm.
 * User: tanakayuuki
 * Date: 2014/12/15
 * Time: 7:47
 */
session_start();
session_destroy();


header("location:../index.php");