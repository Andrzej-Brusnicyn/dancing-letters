<?php
require_once './classes/GenGif.php';

if (isset($_POST["word"])) 
{
    $word = $_POST["word"];
    $launch = new GenGif($word);
    $launch->createGIF();
}