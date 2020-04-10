<?php

if (!isset($_COOKIE['lang'])){
	setcookie('lang', 'fr', null, null, null, false, true);
	echo 'Pas de cookie lang';
	header('Refresh: 1;URL=index.php?lang=fr');

}else if (isset($_GET['lang']) && !empty($_GET['lang'])){
    setcookie('lang', $_GET['lang'], null, null, null, false, true);
}

//include('../international/'.$_COOKIE['lang'].'.php');
//require '/projetAnuel2020/webPart/international/en.php';

?>

<script type="text/javascript">
	try {
		<?php include('../international/'.$_COOKIE['lang'].'.php');?>
	} catch (FileNotFoundException e){
		<?php include('international/'.$_COOKIE['lang'].'.php');?>
	}
</script>
