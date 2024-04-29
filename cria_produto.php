<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/restrito.php';
include $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/estamparia/sp_cadastros.php';

function function_return() {
    echo ' <script> javascript:window.location="index.php";</script> ';
}

$emp = $_SESSION['empresa'];
$filial = $_SESSION['filial'];

$form = null;

foreach($_POST as $key => $dado){

	if(!is_string($dado)){
		$_SESSION['mensagem'] = ['type' => 'error', 'title' => 'ERRO', 'msg' => 'Erro "'.$key.'": Dados enviados incompativeis'];
		function_return();
	}

	if($key != 'cod_int' && $key != 'cod_ext' && $key != 'cod_fabrica' && $key != 'descricao' && $key != 'unidade_de_medida' && $key != 'cod_fidcal' && $key != 'gera_lote' && $key != 'cod_fiscal'){

		if(trim($dado) != null){
			if(!is_numeric($dado)){
				$_SESSION['mensagem'] = ['type' => 'error', 'title' => 'ERRO', 'msg' => 'Erro "'.$key.'": Dados enviados devem ser numéricos'];
				function_return();
			}
		}
	}

    $_POST[$key]= trim($dado);
}

if($_SESSION['mensagem'] === null){

	$form= $_POST;

	$form['cod_int'] = strtoupper($form['cod_int']);
	$form['cod_ext'] = strtoupper($form['cod_ext']);
	$form['descricao'] = strtoupper($form['descricao']);

	if($form['peso_unitario'] != null){
		$form['peso_unitario'] = number_format($form['peso_unitario'], 3, '.','');
	}

	for($i = 1; $i <= 3; $i++){

		if($form['med'.$i] != null){
			$form['med'.$i] = number_format($form['med'.$i], 3, '.', '');
		}
	}

	if($form['gera_lote'] != 'S'){
		$form['gera_lote'] = 'N';
	}
}


if($_SESSION['mensagem'] === null){
    $resultado = spCriaProdutos([$emp, $filial, $form['cod_int'], $form['cod_ext'], $form['origem'], $form['gera_lote'], $form['tipo'], $form['unidade_de_medida'], $form['cod_fiscal'], $form['grupo'], $form['familia'], $form['descricao'], $form['med1'], $form['med2'], $form['med3'], $form['qualidade'], 'A', $form['peso_unitario']]);
}


if($resultado != '' && $resultado != null){

    $_SESSION['mensagem'] = ['type' => 'success', 'title' => 'SUCESSO', 'msg' => 'Produto "'. $form['descricao'] .'" cadastrado; código: ' . $resultado[0]['']];
    function_return();
}
elseif($_SESSION['mensagem'] == null){
	
    $_SESSION['mensagem'] = ['type' => 'error', 'title' => 'ERRO', 'msg' => 'Erro problema ao enviar: problema no envio para o banco de dados'];
    function_return();
}

?>