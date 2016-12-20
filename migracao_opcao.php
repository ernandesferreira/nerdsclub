<style>
body{font-family:'Arial'; background: #f6f6f6; text-align: center; color: #333; overflow-x:hidden; }
.title{
	text-transform: uppercase;
	font-family: fantasy;
	color: #FFF;
	background: -webkit-linear-gradient(#2BA7E5, #207cca);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	font-size: 60px;
	margin: 0;
}

.row{ margin: 15px; width: 100%}

.panel{
	background: #fff;
	width: 500px;
	max-width: 90%;
	display: inline-block;
	padding: 10px;
	border-radius: 5px;
	box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.2);
}

.panel-heading{
	position: absolute;
	font-size: 11px;
	font-weight: bold;
	color: #999;
}

input[type="text"]{
	width: 210px;
	padding: 5px;
	border-radius: 3px;
	border: 1px solid #CCC;
}

input[type="submit"]{

border: 1px solid #1e5799;
color: #FFF;
font-size: 22px;
padding: 10px 45px;
border-radius: 5px;
box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.5);
text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
cursor: pointer;


background: #1e5799; /* Old browsers */
background: -moz-linear-gradient(45deg,  #1e5799 0%, #2989d8 50%, #207cca 51%, #7db9e8 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#1e5799), color-stop(50%,#2989d8), color-stop(51%,#207cca), color-stop(100%,#7db9e8)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(45deg,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(45deg,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(45deg,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* IE10+ */
background: linear-gradient(45deg,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

}

input[type="submit"]:hover{

	box-shadow: 0px 0px 8px 1px rgba(0,0,0,0.5);
}

.help{
	background: #207cca;
	color: #FFF;
	font-size: 11px;
	font-weight: bold;
	padding: 2px 5px;
	border-radius: 50px;
	cursor: help;
}

footer{
	font-size: 10px;
	color: #777;
	margin-top: 50px;
}

a{
	color:#207cca;
}

</style>

<h1 class="title"> Migra&ccedil;&atilde;o </h1>

<?php 

include_once 'wp-config.php';

$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysql_error());
$db = mysql_select_db(DB_NAME) or die(mysql_error());

if(isset($_POST['url_antiga']) && isset($_POST['url_nova'])){

	if (strlen($_POST['url_antiga']) < 5 || strlen($_POST['url_antiga']) < 5){

		//echo "URL Inv&aacute;lida!";
		//return false;

	} 

global $wpdb;

$searchString = str_replace('http://', '', $_POST['url_antiga']);
$novaURL = str_replace('http://', '', $_POST['url_nova']);

// $searchString = str_replace('www.', '', $searchString);
// $novaURL = str_replace('www.', '', $novaURL);

$url_option = str_replace('http://', '',$_POST['url_option']);
$optionAntigo = str_replace('http://', '', $_POST['option_antigo']);
$optionNovo = str_replace('http://', '', $_POST['option_novo']);


$parent_menu = $_POST['parent_menu'];


// Mudar URL do site
if( $_POST['checkoption'] == 's' && $url_option != ''){
	$wpdb->query("UPDATE {$wpdb->options} set option_value='http://{$url_option}' where option_name='siteurl'");
	$wpdb->query("UPDATE {$wpdb->options} set option_value='http://{$url_option}' where option_name='home'");
	echo "Url dos options atualizadas!";
	echo "<br><br><br>";
}


// Mudar Parent dos Menus
if( $_POST['checkmenu'] == 's' && $parent_menu != ''){
	$wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value = replace(meta_value, '/{$parent_menu}','') WHERE meta_key = '_menu_item_url' AND meta_value LIKE '%/{$parent_menu}%' ");
	echo "Parent dos menus atualizados!";
	echo "<br><br><br>";
}

class st2Class {

    public function __construct($obj) {

    	$keys = get_object_vars($obj);
    	foreach ($keys as $key => $value) {

    		if($key != 'url'){
    			$this->$key = str_replace('{$searchString}', '{$novaURL}', $obj->$key);
    		}else{
    			$this->$key =  $obj->$key;
    		}
    	}
        

    }
}


if (strlen($_POST['url_antiga']) > 5 && strlen($_POST['url_antiga']) > 5){

	$query = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE guid LIKE '%{$searchString}%'");
	echo count($query)." post meta encontrado(s)<hr />";
	echo $wpdb->posts;
	echo "<br><br><br>";

	//Atualizar referencias de imagens e links nos posts
	$update = mysql_query("UPDATE {$wpdb->posts} SET post_content = replace(post_content, '{$searchString}','{$novaURL}')");
	$update2 = mysql_query("UPDATE {$wpdb->posts} SET guid = replace(guid,'{$searchString}','{$novaURL}')") or die(mysql_error());
	echo "Bucket/URL da tabela {$wpdb->posts} atualizado!";
	echo "<br><br><br>";




	//Post Meta
	$query = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE meta_value LIKE '%{$searchString}%'");
	echo count($query)." post meta encontrado(s)<hr />";

	foreach ($query as $key => $q1) {
		
		$q2 = get_post_meta($q1->post_id,$q1->meta_key,true);

		if(is_array($q2)){


			$Arraykey = array_search($searchString, $q2);

			$q2[$Arraykey] = $novaURL;

		} 
		else if(is_object($q2)){

			$q2 = new st2Class($q2);	


		} else {

			$q2 = str_replace($searchString, $novaURL, $q2);

		}

		update_post_meta($q1->post_id,$q1->meta_key,$q2);

		echo '<pre>'.print_r($q2, true).'</pre>';

		ob_flush();
	}


	// Comment Meta
	$query2 = $wpdb->get_results("SELECT * FROM {$wpdb->commentmeta} WHERE meta_value LIKE '%{$searchString}%'");
	echo count($query2)." comment meta encontrado(s)<hr />";

	foreach ($query2 as $key => $q1) {
		
		$q2 = get_comment_meta($q1->comment_id,$q1->meta_key,true);

		if(is_array($q2)){

			$Arraykey = array_search($searchString, $q2);

			$q2[$Arraykey] = $novaURL;

		} 
		else if(is_object($q2)){

			$q2 = new st2Class($q2);	


		}else {

			$q2 = str_replace($searchString, $novaURL, $q2);

		}

		update_comment_meta($q1->comment_id,$q1->meta_key,$q2);
		echo '<pre>'.print_r($q2, true).'</pre>';

		ob_flush();
	}

	$revslider = mysql_query('select 1 from '.$wpdb->prefix.'revslider_sliders');

	if( $revslider ){
		// RevSlider
		$wpdb->query("UPDATE {$wpdb->prefix}revslider_settings set params = replace('params', '{$searchString}', '{$novaURL}')");

		$wpdb->query("UPDATE {$wpdb->prefix}revslider_sliders set params = replace('params', '{$searchString}', '{$novaURL}')");

		$wpdb->query("UPDATE {$wpdb->prefix}revslider_slides set params = replace('params', '{$searchString}', '{$novaURL}')");
		$wpdb->query("UPDATE {$wpdb->prefix}revslider_slides set layers = replace('layers', '{$searchString}', '{$novaURL}')");

		echo '<pre>RevSlider atualizado!</pre>';
		ob_flush();
	} else {
		echo 'Tabela <b>'.$wpdb->prefix.'revslider_sliders</b> n&atilde;o encontrada!<br><hr>';
		ob_flush();
	}

}

if( $_POST['checkoption'] == 's' && $url_option != ''){
	if (strlen($optionAntigo) > 2 && strlen($optionNovo) > 2){
		// Options
		$query2 = $wpdb->get_results("SELECT * FROM {$wpdb->options} WHERE option_value LIKE '%{$optionAntigo}%'");
		echo count($query2)." option(s) encontrado(s)<hr />";

		foreach ($query2 as $key => $q1) {
			
			$q2 = get_option($q1->option_name);

			if(is_array($q2)){

				$Arraykey = array_search($optionAntigo, $q2);

				$q2[$Arraykey] = $optionNovo;

			} 
			else if(is_object($q2)){

				$q2 = new st2Class($q2);	


			}else {

				$q2 = str_replace($optionAntigo, $optionNovo, $q2);

			}

			update_option($q1->option_name,$q2);
			echo '<pre>'.print_r($q2, true).'</pre>';

			ob_flush();
		}
	}
}




$wpdb->query("UPDATE {$wpdb->postmeta} set meta_value = replace(meta_value, 'st2Class', 'stdClass')");

$wpdb->query("UPDATE {$wpdb->commentmeta} set meta_value = replace(meta_value, 'st2Class', 'stdClass')");

$wpdb->query("UPDATE {$wpdb->options} set option_value = replace(option_value, 'st2Class', 'stdClass')");


}
?>


<form name="migracao" method="post">

<div class="row">
	<section class="panel">
	<header class="panel-heading">Bucket S3 ou URL</header>
	<br><br>
	<label>Bucket/URL Antiga:</label>
	<input type="text" name="url_antiga" /> <span class="help" title="Digite o nome do bucket ou URL atual, que dever&aacute; ser mudado.">?</span>

	<br><br>

	<label>Bucket/URL Nova:</label>
	<input type="text" name="url_nova" /> <span class="help" title="Digite o nome do novo bucket ou nova URL.">?</span>
	</section>
</div>

<div class="row">
	<section class="panel">
	<header class="panel-heading">Options</header>
	<label>Options Antigo:</label>
	<input type="text" name="option_antigo" /> <span class="help" title="Digite a URL atual do option que ser&aacute; modificada pela url abaixo.">?</span>
	<br><br>
	<label>Options Novo:</label>
	<input type="text" name="option_novo" /> <span class="help" title="Digite a nova URL que ser&aacute; usada nos options que conterem a url do campo anterior.">?</span>
	<br><br>
	<label>Options URL:</label>
	<input type="text" name="url_option" /> <span class="help" title="Digite a nova URL que ser&aacute; usada nos options siteurl e home.">?</span>
	<br><br>

	<labe><small>Marque caso deseje Atualizar Options:</small> </labe>
	<input type="checkbox" name="checkoption" value="s">
	</section>
</div>

<div class="row">
	<section class="panel">
	<header class="panel-heading">Menus</header>
	<label>Parent Menu:</label>
	<input type="text" name="parent_menu" /> <span class="help" 
	title='Digite a palavra que deseja tirar do menu. 
Ex: Para mudar URL do menu "teste.com.br/parent_do_menu/pagina" para "teste.com.br/pagina", digite "parent_do_menu".'>?</span>
	<br><br>

	<labe><small>Marque caso deseje Retirar o parent do meu: </small></labe>
	<input type="checkbox" name="checkmenu" value="s">
	</section>
</div>


<div class="row">
	<input type="submit" name="migrar" value="Migrar">
</div>

</form>



<footer>
	Criado por <a href="http://trii.com.br">Trii</a> | Vers&atilde;o 2.1
</footer>
