<?php

if (isset($_POST['id']) && isset($_POST['name']) && isset($_GET['folder']))
{
	echo '<a href="index.php?route=images&action=preview&id='.$_POST['id'].'">';
	echo '<img src="'.$_GET['folder'].$_POST['id'].'" class="ListImage" style="width: 100%; height: 100%;" alt="Loading..." />';
	echo '</a>';
	echo '<p style="text-align: center; padding-top: 10px;">Image '.$_POST['id'].'. <b>'.$_POST['name'].'</b></p>';
}

?>
