<?php
// include '../restrito.php';
include $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/conn2.php';
/*
** Helpers
*/

ini_set("memory_limit","1024M");

function pre($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die;
}

function converteData($var) {
    $data = strtotime($var);
    $data = date('Y-m-d', $data);
    if($data == '1962-12-31'){
        $data = '';
    }
    return $data;
}

function converteMes($var) {
    $data = strtotime($var.'01');
    $data = date('Y-m', $data);
    if($data == '1969-12-31'){
        $data = '';
    }
    return $data;
}

function converteHora($var) {
    $data = strtotime($var);
    $data = date('H:i:s', $data);
    // if($data == '1969-12-31'){
    //     $data = '';
    // }
    return $data;
}

// Função para ordenar matriz em ordem alfabetica
function cmp($a, $b) {
	return $a['nome'] > $b['nome'];
    // é assim que usa: usort($array, 'cmp');
}

function ordenaArray($array, $campo) {
    usort($array, function ($a, $b) use ($campo) {
        return $a[$campo] > $b[$campo];
    });
    return $array;
}

function xml2array ( $xmlObject, $out = array () ){
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

/*
** Usuarios
*/

function spUsuarios($params) {
    $tsql = "exec consulta_usuarios @usuario=?, @tipo=?, @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAcesso($params) {
    $tsql = "exec consulta_acesso @usuario=?, @senha=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $arr = $row;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//MODULOS
function spConsultaModulos($params) {
    $tsql = "exec consulta_modulos @empresa=?, @filial=?, @modulo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaModulosUsuario($params) {
    $tsql = "exec consulta_modulos_usuario @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaProgramaUsuario($params) {
    $tsql = "exec consulta_programas_usuarios @usuario=?, @opcao=?, @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/*
** Empresas & Filiais
*/

function spEmpresa($params) {
    $tsql = "exec consulta_empresa @empresa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spFiliais($params) {
    $tsql = "exec consulta_filiais @filial=?, @empresa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/*
** Menus & Programas
*/

function spMenu($params) {
    $tsql = "exec consulta_menus_usuario @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spOpMenu($params) {
    $tsql = "exec consulta_opprog @usuario=?, @empresa=?, @filial=?, @modulo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spMenuProg($params) {
    $tsql = "exec consulta_menu_prog @programa=?, @opcao=?, @empresa=?, @filial=?, @usuario=?, @modulo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spProgramasUser($params) {
    $tsql = "exec consulta_programas_usuarios @usuario=?, @modulo=?, @empresa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spProgramas($params) {
    $tsql = "exec consulta_programas @programa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spOpcao($params) {
    $tsql = "exec consulta_opcao @usuario=?, @programa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/*
** CNPJ
*/

function isCnpjValid($cnpj) {
   //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
   $j=0;
   for ($i = 0; $i < (strlen($cnpj)); $i++)
       {
           if (is_numeric($cnpj[$i]))
               {
                   $num[$j] = $cnpj[$i];
                   $j++;
               }
       }
   //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
   if (count($num) != 14)
       {
           $isCnpjValid = false;
       }
   //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
   if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
       {
           $isCnpjValid=false;
       }
   //Etapa 4: Calcula e compara o primeiro dígito verificador.
   else
       {
           $j=5;
           for ($i=0; $i < 4; $i++)
               {
                   $multiplica[$i] = $num[$i] * $j;
                   $j--;
               }
           $soma = array_sum($multiplica);
           $j = 9;
           for($i=4; $i<12; $i++)
               {
                   $multiplica[$i]=$num[$i]*$j;
                   $j--;
               }
           $soma = array_sum($multiplica);
           $resto = $soma%11;
           if($resto<2)
               {
                   $dg=0;
               }
           else
               {
                   $dg=11-$resto;
               }
           if($dg!=$num[12])
               {
                   $isCnpjValid=false;
               }
       }
   //Etapa 5: Calcula e compara o segundo dígito verificador.
   if(!isset($isCnpjValid))
       {
           $j=6;
           for($i=0; $i<5; $i++)
               {
                   $multiplica[$i]=$num[$i]*$j;
                   $j--;
               }
           $soma = array_sum($multiplica);
           $j=9;
           for($i=5; $i<13; $i++)
               {
                   $multiplica[$i]=$num[$i]*$j;
                   $j--;
               }
           $soma = array_sum($multiplica);
           $resto = $soma%11;
           if($resto<2)
               {
                   $dg=0;
               }
           else
               {
                   $dg=11-$resto;
               }
           if($dg!=$num[13])
               {
                   $isCnpjValid=false;
               }
           else
               {
                   $isCnpjValid=true;
               }
       }
   //Etapa 6: Retorna o Resultado em um valor booleano.
   return $isCnpjValid;
}

function deixarNumero($string){
    return preg_replace("/[^0-9]/", "", $string);
}

function buscaCnpj($param) {
    $param = deixarNumero($param);

    if($param != null && strlen($param) == 14){
        $valido = isCnpjValid($param);
    }

    if($valido != true) {
        echo "<script type='text/javascript'>toastr.error('Erro cnpj invalido, verifique e tente novamente','Cnpj Invalido',{ timeOut: 6000});</script>";

    }else {
        $url = "http://receitaws.com.br/v1/cnpj/$param";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        curl_close($curl);

        $resp = json_decode($resp);

        return $resp;
    }
}

function spPerfil($params) {
    $tsql = "exec consulta_perfil  @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/*
** CPF
*/

function validacpf($cpf) {
 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}

/*
** ORDEM DE COMPRA
*/


function convertDate ($data){

    $sep = date_create($data);
    $num = date_format($sep,"Y-m-d");

    return $num;
}

/*
** lotes validos
*/
function spLotesValidos($params) {
    $tsql = "exec consulta_prodlote_transf @empresa=?, @filial=?, @lote=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
   
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);  
    return $arr;
}

/*
** Consulta Produtos de Destino
*/
function spProdutosDestino($params) {
    $tsql = "exec consulta_produtos_dest @empresa=?, @filial=?, @caprod=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
   
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);  
    return $arr;
}


// Consulta Ordem de Compra

function spConsultadeCompras ($params) {
    $tsql = "exec consulta_ordcomp @empresa=?, @filial=?, @grupo=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Consulta grupos

function spConsultaGrupoOrdem ($params) {
    $tsql = "exec consulta_grupos_ordem @empresa=?, @filial=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Consulta Item de Compra

function spConsultadeComprasItens ($params) {
    $tsql = "exec consulta_itemordcomp @empresa=?, @filial=?, @numoc=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFilial ($params) {
    $tsql = "exec consulta_filiais @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaEmpresa ($params) {
    $tsql = "exec consulta_empresa @empresa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFornecedor ($params) {
    $tsql = "exec consulta_clifor @empresa=?, @filial=?, @cnpj=?, @codigo=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spPesquisaTabela ($params) {
    $tsql = "exec pesquisa_tabelas @empresa=?, @filial=?, @filiais=?, @dataini=?, @datafim=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spMostraIndicadores ($params) {
    $tsql = "exec mostra_indicadores @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaIndicadores ($params) {
    $tsql = "exec consulta_indicadores  @empresa=?, @filial=?, @filiais=?, @dataini=?, @datafim=?, @tipo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheIndicadores ($params) {
    $tsql = "exec consulta_detalhe_indicadores  @empresa=?, @filial=?, @filiais=?, @dataini=?, @datafim=?, @tipo=?, @codigo=?, @unidade=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDocumento ($params) {
    $tsql = "exec consulta_documento  @empresa=?, @filial=?, @especie=?, @dataini=?, @datafim=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheDocumento ($params) {
    $tsql = "exec consulta_detalhe_documento  @empresa=?, @filial=?,  @especie=?, @codigo=?, @dataini=?, @datafim=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCompromissos ($params) {
    $tsql = "exec consulta_compromissos  @empresa=?, @filial=?,  @data1=?, @data2=?, @tipo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAvaliacoes ($params) {
    $tsql = "exec consulta_avaliacoes  @empresa=?, @filial=?, @avaliacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTipoCliFor ($params) {
    $tsql = "exec consulta_tipoclifor  @empresa=?, @filial=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAplicacaodeProdutos ($params) {
    $tsql = "exec consulta_aplicacoes  @empresa=?, @filial=?, @aplicacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSerie ($params) {
    $tsql = "exec consulta_series  @empresa=?, @filial=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaClassificacaoFiscais($params) {
    $tsql = "exec consulta_clafisc  @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaReferenciafiscal($params) {
    $tsql = "exec consulta_ncm  @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spClienteEDI($params) {
    $tsql = "exec consulta_endedi @empresa=?,@filial=?,@codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spGeraMovimentoEDI($params) {
    $tsql = "exec gera_movimento @empresa=?,@filial=?,@cliente=?,@usuario=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaMovimentoEDI($params) {
    $tsql = "exec consulta_movimento @empresa=?, @filial=?, @usuario=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaResultadoEDI($params) {
    $tsql = "exec consulta_resultedi @empresa=?,@filial=?,@fabrica=?,@usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSaldosEDI($params) {
    $tsql = "exec consulta_saldosedi @empresa=?,@filial=?,@fabrica=?,@codint=?,@usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaProgEDI($params) {
    $tsql = "exec consulta_progedi @empresa=?, @filial=?,@fabrica=?, @codint=?,@dtmovimento=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaNotaFiscalEDI($params) {
    $tsql = "exec consulta_nfedi @empresa=?,@filial=?,@cliente=?,@produto=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPrazos($params) {
    $tsql = "exec consulta_prazos @empresa=?,@filial=?,@prazo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaEspecies($params) {
    $tsql = "exec consulta_especies @empresa=?, @filial=?, @especie=?, @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTransportador($params) {
    $tsql = "exec consulta_transportador @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaRegNotaFiscalEDI($params) {
    $tsql = "exec consulta_reg_nfedi @empresa=?,@filial=?,@cliente=?,@nota=?,@especie=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaItemNotaFiscalEDI($params) {
    $tsql = "exec consulta_item_nfedi @empresa=?, @filial=?, @nota=?, @especie=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaProduto($params) {
    $tsql = "exec consulta_produto @empresa=?, @filial=?, @codint=?, @produto=?, @codext=?, @grupo=?, @familia=?, @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFerramenta($params) {
    $tsql = "exec consulta_ferramentas @empresa=?, @filial=?, @codop=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaGrupos($params) {
    $tsql = "exec consulta_grupos @empresa=?, @filial=?, @grupo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTipoProduto($params) {
    $tsql = "exec consulta_tipoprod @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaOperacao($params) {
    $tsql = "exec consulta_operaestampo @empresa=?, @filial=?, @codext=?, @codint=?, @codop=?, @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaOrigem($params) {
    $tsql = "exec consulta_origem @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFamilias($params) {
    $tsql = "exec consulta_familias @empresa=?, @filial=?, @familia=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaQualidades($params) {
    $tsql = "exec consulta_qualidades @empresa=?, @filial=?, @qualidade=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaUnidades($params) {
    $tsql = "exec consulta_unidades @unidade=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaEstado ($params) {
    $tsql = "exec consulta_ufs @uf=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaMunicipio ($params) {
    $tsql = "exec consulta_municipios @codigo=?, @uf=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSetores ($params) {
    $tsql = "exec consulta_setores @empresa=?, @filial=?, @setor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCustosGerais ($params) {
    $tsql = "exec consulta_custo @empresa=?, @filial=?, @dataini=?, @datafim=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaHomologacaoFornecedor ($params) {
    $tsql = "exec consulta_homologfor @empresa=?, @filial=?, @codfor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaEmbalagem ($params) {
    $tsql = "exec consulta_embalagens @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaRamos ($params) {
    $tsql = "exec consulta_ramos @empresa=?, @filial=?, @ramo=?, @setor=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTipoPessoa ($params) {
    $tsql = "exec consulta_tipopessoa @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendedores ($params) {
    $tsql = "exec  consulta_vendedores @empresa=?,@filial=?, @usuario=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAssistente ($params) {
    $tsql = "exec consulta_assistentes @empresa=?, @filial=?, @usuario=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPrecoVenda ($params) {
    $tsql = "exec consulta_precovenda @empresa=?, @filial=?, @familia=?, @grupo=?, @qualidade=?, @espessurade=?, @espessurate=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTodosPrecoVenda ($params) {
    $tsql = "exec consulta_histprecovenda @empresa=?, @filial=?, @produto=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDadosAdicionais ($params) {
    $tsql = "exec consulta_adicionais @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaContatos ($params) {
    $tsql = "exec consulta_contatos @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPromotores ($params) {
    $tsql = "exec consulta_promotores @empresa=?, @filial=?, @vendedor=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaModalidades ($params) {
    $tsql = "exec consulta_modalidades @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaReferencia ($params) {
    $tsql = "exec consulta_fichapro @empresa=?, @filial=?, @cliente=?, @produto=?, @refere=?, @versao=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaNatureza ($params) {
    $tsql = "exec consulta_naturezas @empresa=?, @filial=?, @natureza=?, @especie=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAvaliacaoClifor ($params) {
    $tsql = "exec consulta_avalia_clifor @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCobranca ($params) {
    $tsql = "exec consulta_cobrancas @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaNumeroVenda ($params) {
    $tsql = "exec consulta_numero @empresa=?, @filial=?, @serie=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendas ($params) {
    $tsql = "exec consulta_vendas @empresa=?, @filial=?, @codigo=?, @venda=?, @tipo=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendasItens ($params) {
    $tsql = "exec consulta_vendasitem @empresa=?, @filial=?, @venda=?, @promotor=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDocumentosClifor ($params) {
    $tsql = "exec consulta_documento_clifor @empresa=?, @filial=?, @codigo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaProgramacaoVendas ($params) {
    $tsql = "exec consulta_programacao_vendas @empresa=?, @filial=?, @venda=?, @item=?, @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaNotasSaiVendas ($params) {
    $tsql = "exec consulta_notassai_vendas @empresa=?, @filial=?, @venda=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}





/*
** Ficha Técnica
*/

function spCliForFicha ($params) {
    $tsql = "exec consulta_clifor_ficha @empresa=?, @filial=?, @cnpj=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spElemento($params) {
    $tsql = "exec consulta_elementos @item=?, @codigo=?, @elemento=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spElementosNormasi($params) {
    $tsql = "exec consulta_elementos_normasi @empresa=?, @filial=?, @norma=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spFichaHistorico($params) {
    $tsql = "exec consulta_fichahis @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spFichaObsCliente($params) {
    $tsql = "exec consulta_fichas @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spFichaObsProduto($params) {
    $tsql = "exec consulta_fichaobs @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spHistoricoProd($params) {
    $tsql = "exec consulta_fichaproh @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spNormas($params) {
    $tsql = "exec consulta_normas @empresa=?, @filial=?, @norma=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spNormasFicha($params) {
    $tsql = "exec consulta_normasficha @empresa=?, @filial=?, @codigo=?, @produto=?, @referencia=?, @versao=?, @norma=?, @item=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spObservacaoCliente($params) {
    $tsql = "exec consulta_obsclificha @empresa=?, @filial=?, @codigo=?, @ficha=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spObservacaoFicha($params) {
    $tsql = "exec consulta_fichaprog @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spObservacaoProd($params) {
    $tsql = "exec consulta_fichaproo @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioCliFicha($params) {
    $tsql = "exec relatorio_clificha @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioFichaTec($params) {
    $tsql = "exec relatorio_fichatec @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioHistProd($params) {
    $tsql = "exec relatorio_fichaproh @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioNormas($params) {
    $tsql = "exec relatorio_normasficha @empresa=?, @filial=?, @codigo=?, @produto=?, @referencia=?, @versao=?, @norma=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioProdutoObs($params) {
    $tsql = "exec relatorio_fichaproo @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioProg($params) {
    $tsql = "exec relatorio_fichaprog @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spNormasItem($params) {
    $tsql = "exec consulta_normasi @empresa=?, @filial=?, @norma=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spCertificado($params) {
    $tsql = "exec consulta_certificado @empresa=?, @filial=?, @certificado=?, @volume=?, @ordem=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendasItem($params) {
    $tsql = "exec consulta_vendasitem @empresa=?, @filial=?, @venda=?, @promotor=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaProgramacao($params) {
    $tsql = "exec consulta_programacao @empresa=?, @filial=?, @venda=?, @tipo=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVoluCC($params) {
    $tsql = "exec consulta_volucc @empresa=?, @filial=?, @volume=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVoluCU($params) {
    $tsql = "exec consulta_volucu @empresa=?, @filial=?, @volume=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFichaTecBloq($params) {
    $tsql = "exec consulta_ficha_bloqueada @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaNormasBloq($params) {
    $tsql = "exec consulta_normasp_bloqueada @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCertBloq($params) {
    $tsql = "exec consulta_certificado_bloqueado @empresa=?, @filial=?, @certificado=?, @volume=?, @ordem=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// INICIO - ORDEM DE PRODUÇÃO - FAVOR NÃO MEXER //
function spGera_indicaprogramacao($params) {
    $tsql = "EXEC gera_indicaprogramacao @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGera_indicaprogramacao15($params) {
    $tsql = "EXEC gera_indicaprogramacao15 @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGera_indicaprogramacao30($params) {
    $tsql = "EXEC gera_indicaprogramacao30 @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGera_indicaprogramacao60($params) {
    $tsql = "EXEC gera_indicaprogramacao60 @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGera_indicaprogramacao90($params) {
    $tsql = "EXEC gera_indicaprogramacao90 @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGera_indicaprogramacao2($params) {
    $tsql = "EXEC gera_indicaprogramacao2 @empresa=?, @filial=?, @data=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}



function spMostra_indicaprogramacao($params) {
    $tsql = "exec mostra_indicaprogramacao @empresa=?, @filial=?, @grupo=?, @familia=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}



function spConsulta_indicadorproducao($params) {
    $tsql = "exec consulta_indicadorproducao @empresa=?, @filial=?, @grupo=?, @familia=?, @med1=?, @tipo=?, @dias=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}
function spSeleciona_indicadorpcp($params) {
    $tsql = "exec seleciona_indicador_pcp @empresa=?, @filial=?, @grupo=?, @familia=?, @med1=?, @tipo=?, @dias=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spIndica_volumes($params) {
    $tsql = "EXEC indica_volumes @empresa=?, @filial=?, @grupo=?, @familia=?, @espessura=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spConstultaIndica_volumes($params) {
    $tsql = "exec consulta_indicavolumes @empresa=?, @filial=?, @grupo=?, @familia=?, @med1=?, @usuario=?, @tipo=?, @pesototal=?, @quali=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function Lb($params) {
    $tsql = "exec consulta_desvio @empresa=?, @filial=?, @venda=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spBloqueiaVolume($params) {
    $tsql = "exec bloqueia_volume @empresa=?, @filial=?, @volume=?, @ordem=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAnalizaVolumes($params) {
    $tsql = "exec analiza_volumes @empresa=?, @filial=?, @venda=?, @itemvenda=?, @vendedor=?, @promotor=?, @volume=?, @ordem=?, @codigo=?, @produto=?, @refere=?, @espessura=?, @grupo=?, @familia=?, @usuario=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAbandonaDesvio($params) {
    $tsql = "exec abandona_desvio @empresa=?, @filial=?, @codigo=?, @produto=?, @referencia=?, @norma=?, @venda=?, @item=?, @vendedor=?, @promotor=?, @volume=?, @ordem=?, @usuario=?, @observa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDesvio($params) {
    $tsql = "exec consulta_desvio @empresa=?, @filial=?, @venda=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spBloqueiaVendas($params) {
    $tsql = "exec bloqueia_vendas @empresa=?, @filial=?, @venda=?,@tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPosicoes($params) {
    $tsql = "exec consulta_posicoes @empresa=?, @filial=?, @posicao=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaMaquinasProd($params) {
    $tsql = "exec consulta_maquinas_prod @empresa=?, @filial=?, @maquina=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spVerificaFichaProd($params) {
    $tsql = "exec verifica_fichapro @empresa=?, @filial=?, @cliente=?, @produto=?, @refere=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
	
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $arr = $row;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spSeleciona_pedidos($params) {
    $tsql = "EXEC seleciona_pedidos @empresa=?, @filial=?, @venda=?, @item=?, @usuario=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spPlanoCorte3($params) {
    $tsql = "EXEC planodecorte3 @empresa=?, @filial=?, @usuario=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spConsultaPlanoCorte($params) {
    $tsql = "exec consulta_planocorte @empresa=?, @filial=?, @volume=?, @ordem=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaItemPlanoCorte($params) {
    $tsql = "exec consulta_itemplanocorte @empresa=?, @filial=?, @volume=?, @ordem=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendaItemSep($params) {
    $tsql = "exec consulta_vendasitem_separacao @empresa=?, @filial=?, @venda=?, @item=?, @produto=?, @peso=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaVolAcabadoAco($params) {
    $tsql = "exec consulta_volume_acabado_aco @empresa=?, @filial=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVolSeparacao($params) {
    $tsql = "exec consulta_volume_separacao @empresa=?, @filial=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAlocaVolumes($params) {
    $tsql = "EXEC aloca_volume @empresa=?, @filial=?, @volume=?, @ordem=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAlocaVendas($params) {
    $tsql = "EXEC aloca_vendas @empresa=?, @filial=?, @numero=?, @item=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaSeparacao($params) {
    $tsql = "EXEC cria_ordem_separacao @empresa=?, @filial=?, @volume=?, @ordem=?, @venda=?, @item=?, @descricao=?, @observacao=?, @usuario=?, @codigo=?, @qtde=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
	
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $arr = $row;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// FIM - ORDEM DE PRODUÇÃO - FAVOR NÃO MEXER //
// INICIO - ORDEM DE COMPRA - FAVOR NÃO MEXER //

function spConsultaCotacao($params) {
    $tsql = "exec  consulta_cotacao @empresa=?, @filial=?, @numoc=?, @aprovacao=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFornItemCot($params) {
    $tsql = "exec  consulta_forn_itemcotacao @empresa=?, @filial=?, @numoc=?, @item=?, @aprovacao=?, @fornecedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaCotAprov($params) {
    $tsql = "exec  consulta_cotacao_aprovadas @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[2] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaStatCot($params) {
    $tsql = "exec  consulta_statuscotacao @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSitCot($params) {
    $tsql = "exec  consulta_sitcotacao @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    if($params[0] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function sp_Cria_ordemcom($params) {
    $tsql = "EXEC cria_ordcomp @empresa=?, @filial=?, @pedido=?, @codigo=?, @usuario=?, @ccusto=?, @pagto=?, @dtrecebe=?, @observacao=?, @vlrprod=?, @vlripi=?, @vlricms=?, @vlrdesc=?, @vlrtotal=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function sp_Cria_itemOrdemcom($params) {
    $tsql = "EXEC cria_itemordcomp @empresa=?, @filial=?, @pedido=?, @numordem=?, @item=?, @codigo=?, @produto=?, @qtdprod=?, @vlunit=?, @percipit=?, @vlrtotit=?, @percicmsit=?, @ccf=?, @vlrdesc=?, @percdesc=?, @vlripit=?, @vlricmsit=?, @dtentrega=?, @observacao=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function sp_Altera_CotOrdem($params) {
    $tsql = "EXEC altera_cotacao_ordem @empresa=?, @filial=?, @numcotacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function sp_Consulta_Ordemcomp($params) {
    $tsql = "EXEC consulta_ordemcomp @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

  if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    if($params[2] != '') {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $arr = $row;
    }else {
        $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;
    }
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function sp_Consulta_ItemOrdemcomp($params) {
    $tsql = "EXEC consulta_item_ordemcomp @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

  if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function sp_Altera_OrdemComp($params) {
    $tsql = "EXEC altera_ordemcomp @empresa=?, @filial=?, @ordcomp=?, @usuario=?, @pagto=?, @dtrecebe=?, @vlrprod=?, @vlripi=?, @vlricms=?, @vlrdesc=?, @vlrtotal=?, @observacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function sp_Altera_ItemOrdComp($params) {
    $tsql = "EXEC altera_itemordcomp @empresa=?, @filial=?, @ordcomp=?, @item=?, @qtdprod=?, @vlrunit=?, @percipit=?, @vlrtotit=?, @percicmsit=?, @vlrdesc=?, @percdesc=?, @vlripit=?, @vlricmsit=?, @dtentrega=?, @observacao=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function sp_Cancela_ordemcom($params) {
    $tsql = "EXEC cancela_ordemcomp @empresa=?, @filial=?, @ordcomp=?, @versao=?, @usuario=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}




// FIM - ORDEM DE COMPRA - FAVOR NÃO MEXER //


// SOLICITACAO DE COMPRAS 

function spConsultaUsuarioEmpresa($params) {
    $tsql = "exec consulta_usuarios_empresa @usuario=?, @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSetor($params) {
    $tsql = "exec consulta_ccusto @ccusto=?, @empresa=?, @filial=?, @nivel=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaContacoes($params) {
    $tsql = "exec consulta_cotacoes @empresa=?, @filial=?, @cotacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaItemCotacoes($params) {
    $tsql = "exec consulta_itemcotacoes @empresa=?, @filial=?, @numoc=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaContacao($params) {
    $tsql = "exec consulta_cotacao @empresa=?, @filial=?, @numoc=?, @aprovacao=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaItemCotacao($params) {
    $tsql = "exec consulta_itemcotacao @empresa=?, @filial=?, @numoc=?, @item=?, @aprovacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioCotacao($params) {
    $tsql = "exec relatorio_cotacoes @empresa=?, @filial=?, @numcotacao=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaCotacaoAberta($params) {
    $tsql = "exec consulta_cotacao_aberta @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaUfsForn($params) {
    $tsql = "exec consulta_ufs @uf=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaOrdemCompCotacao($params) {
    $tsql = "exec consulta_ordemcomp_cotacao @empresa=?, @filial=?, @numped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaItemCotacaoAprovada($params) {
    $tsql = "exec consulta_itemcotacao_aprovada @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//ORDEM PAGAMENTO
function spConsultaHistoricos($params) {
    $tsql = "exec consulta_historicos @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaTipoCobranca($params) {
    $tsql = "exec consulta_tipocobranca @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaBanco($params) {
    $tsql = "exec consulta_banco @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaContasApagar($params) {
    $tsql = "exec consulta_apagar @empresa=?, @filial=?, @codigo=?, @nota=?, @item=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Extrato do fornecedor
function spConsultaExtratoForn($params) {
    $tsql = "exec consulta_extrato_forn @empresa=?, @filial=?, @codigo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRalatorioExtratoForn($params) {
    $tsql = "exec relatorio_extrato_forn @empresa=?, @filial=?, @codigo=?, @tipo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaFluxoCaixa($params) {
    $tsql = "exec consulta_fluxodecaixa @empresa=?, @filial=?, @data=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioFluxoCaixa($params) {
    $tsql = "exec relatorio_fluxodecaixa @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAlteraFluxoCaixa($params) {
    $tsql = "exec altera_fluxodecaixa @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheFluxo($params) {
    $tsql = "exec consulta_detalhe_fluxo @empresa=?, @filial=?, @dataini=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDocumentoFluxo($params) {
    $tsql = "exec consulta_documento_fluxo @empresa=?, @filial=?, @tipo=?, @dataini=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaContasReceber($params) {
    $tsql = "exec consulta_areceber @empresa=?, @filial=?, @codigo=?, @nota=?, @item=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Desdobramento de Duplicatas
function spConsultaNotas ($params) {
    $tsql = "exec consulta_notas @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPrazoDias ($params) {
    $tsql = "exec consulta_prazosdias @empresa=?, @filial=?, @prazo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAReceberBanco ($params) {
    $tsql = "exec consulta_areceber_banco @empresa=?, @filial=?, @banco=?, @agencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSituacaoRecebe ($params) {
    $tsql = "exec consulta_sitrecebe @empresa=?, @filial=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCliForRebece ($params) {
    $tsql = "exec consulta_clifor_receber @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCliForPagamento ($params) {
    $tsql = "exec consulta_clifor_pagamento @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Relatório Pagar/Receber
function spRelatorioPagarReceber ($params) {
    $tsql = "exec relatorio_pagareceber @empresa=?, @filial=?, @dataini=?, @datafim=?, @movimento=?, @ordenacao=?, @codigo=?, @tipo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Cadastro de Banco
function spConsultaConstas ($params) {
    $tsql = "exec consulta_contas @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaInstrucao ($params) {
    $tsql = "exec consulta_instrucoes @banco=?, @instrucao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaEspecieBanco ($params) {
    $tsql = "exec consulta_especibco @banco=?, @especie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTransacaoBanco ($params) {
    $tsql = "exec consulta_transacaobco @banco=?, @transacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaBancoGeral ($params) {
    $tsql = "exec consulta_banco_geral @empresa=?, @filial=?, @banco=?, @agencia=?, @baagencia=?, @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaReceberBordero ($params) {
    $tsql = "exec consulta_receber_bordero @empresa=?, @filial=?, @tipo=?, @banco=?, @baagencia=?, @baconta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['valortotal'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCobrancas ($params) {
    $tsql = "exec consulta_cobrancas @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/*
** Cadastros Gerais do Sistema
*/
function spConsultaCartaCorrecao ($params) {
    $tsql = "exec consulta_carta_correcao @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCodigoComissao ($params) {
    $tsql = "exec consulta_codigocomissao @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDespesas ($params) {
    $tsql = "exec consulta_despesas @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaIcms ($params) {
    $tsql = "exec consulta_codcsticms @origem=?, @codigo=?, @csticms=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaIpi ($params) {
    $tsql = "exec consulta_codcstipi @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCodigoPisCofins ($params) {
    $tsql = "exec consulta_codcstpiscofins @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTipoProd ($params) {
    $tsql = "exec consulta_tipoprod @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//ARQUIVO ENVIO DE BANCO
function spGeraHeaderBanco ($params) {
    $tsql = "exec gera_header_bco @empresa=?, @filial=?, @banco=?, @agencia=?, @baconta=?, @vdata=?, @tipo=?, @baagencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//ARQUIVO ENVIO DE BANCO
function spGeraHeaderBanco2 ($params) {
    $tsql = "exec gera_header_bco_2 @empresa=?, @filial=?, @banco=?, @agencia=?, @baconta=?, @vdata=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//INDICADOR ORDEM DE VENDA
function spGeraIndicadorBloqueio ($params) {
    $tsql = "exec gera_indicabloqueios @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spMostrarIndicadorBloqueio ($params) {
    $tsql = "exec mostra_indicabloqueios @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spGeraIndicaVenda ($params) {
    $tsql = "exec gera_indicavendas @empresa=?, @filial=?, @usuario=?, @bloqueio=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spMostrarIndicaVendas ($params) {
    $tsql = "exec mostra_indicavendas @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spMostrarVendasBloq ($params) {
    $tsql = "exec mostra_vendasbloqueadas @empresa=?, @filial=?, @usuario=?, @bloqueio=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spLiberarVenda ($params) {
    $tsql = "exec libera_vendasc @empresa=?, @filial=?, @codigo=?, @numero=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVendasTotais ($params) {
    $tsql = "exec consulta_total_vendas @empresa=?, @filial=?, @venda=?, @bloqueio=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spTesteLivro ($params) {
    $tsql = "exec consulta_livros @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?, @natureza=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaLivro ($params) {

    $tsql = "exec consulta_livros @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?, @natureza=?, @dataini=?, @datafim=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spApuraImpostos($params) {

    $tsql = "exec apura_impostos @empresa=?, @filial=?, @dataini=?, @datafim=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['vl09'] = $valor;
    
    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spRelatorioImpostos ($params) {

    $tsql = "exec relatorio_impostos @empresa=?, @filial=?, @dataini=?, @datafim=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spRelatorioCertificado($params){
    $tsql = "exec relatorio_certificado @empresa=?, @filial=?, @inspecao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaEnquadraIPI($params){
    $tsql = "exec consulta_enquadraIPI @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

/**
 * Dashboard Qualidade
 */
function spConsultaPesquisaCertificados($params){
    $tsql = "exec pesquisa_certificados @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spMostraIndicadoresCertificados($params){
    $tsql = "exec mostra_indicadores_certificados @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaIndicadoresCertificados($params){
    $tsql = "exec consulta_indicadores_certificados @empresa=?, @filial=?, @tipo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVolumeNaoConforme($params){
    $tsql = "exec consulta_volume_naoconforme @empresa=?, @filial=?, @rnc=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaPesquisaFichaBloq($params){
    $tsql = "exec pesquisa_fichabloqueada @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaTratamentos($params){
    $tsql = "exec consulta_tratamentos @empresa=?, @filial=?, @tratamento=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaMedidaLote($params){
    $tsql = "exec consulta_medidas_lote @empresa=?, @filial=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVolumeSemCertificado($params){
    $tsql = "exec consulta_volume_sem_certificado @empresa=?, @filial=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}
/**
 * Fim Dashboard Qualidade
 */


function spConsultaVolume($params){
    $tsql = "exec consulta_volume @empresa=?, @filial=?, @volume=?, @ordem=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


function spConsultaNotasVolume($params){
    $tsql = "exec consulta_notas_volumes @empresa=?, @filial=?, @volume=?, @ordem=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotasSaiVolume($params){
    $tsql = "exec consulta_notassai_volumes @empresa=?, @filial=?, @volume=?, @ordem=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaAlocacoesVolume($params){
    $tsql = "exec consulta_alocacoes_volumes @empresa=?, @filial=?, @volume=?, @venda=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaProgramacaoVolume($params){
    $tsql = "exec consulta_programacao_volumes @empresa=?, @filial=?, @volume=?, @ordem=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaReceberEnviar($params){
    $tsql = "exec consulta_receber_enviar @empresa=?, @filial=?, @banco=?, @vdata=?, @carteira=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['valortotal'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Consulta de Saldos
function spConsultaSaldos2($params){
    $tsql = "exec consulta_saldos2 @empresa=?, @filial=?, @familia=?, @grupo=?, @med1=?, @med2=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaSaldoVolume($params){
    $tsql = "exec consulta_saldo_volumes @empresa=?, @filial=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVolumeSaldo($params){
    $tsql = "exec consulta_volume_saldo @empresa=?, @filial=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVolumeAlocacao($params){
    $tsql = "exec consulta_volumes_alocacoes @empresa=?, @filial=?, @produto=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVendasItemProd($params){
    $tsql = "exec consulta_vendasitem_produto @empresa=?, @filial=?, @promotor=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaTerceiros($params){
    $tsql = "exec consulta_terceiros @empresa=?, @filial=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotasSaiTerceiros($params){
    $tsql = "exec consulta_notassai_terceiros @empresa=?, @filial=?, @nota=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}
// Fim Consulta Saldos


function spConsultaCotacaoVenda($params){
    $tsql = "exec consulta_cotacaovenda @empresa=?, @filial=?, @codigo=?, @venda=?, @tipo=?, @vendedor=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaItemCotacaoVenda($params){
    $tsql = "exec consulta_itemcotacaovenda @empresa=?, @filial=?, @cotacao=?, @item=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaProdutoAco($params){
    $tsql = "exec consulta_produto_aco @empresa=?, @filial=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaAlteraCotacaoVenda($params){
    $tsql = "exec consulta_alterar_cotacaovenda @empresa=?, @filial=?, @codigo=?, @venda=?, @tipo=?, @vendedor=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


/**
* Tabela de Preco
*/

function spConsultaFamiliaPreco($params){
    $tsql = "exec consulta_familias_preco @empresa=?, @filial=?, @familia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaGruposPreco($params){
    $tsql = "exec consulta_grupos_preco @empresa=?, @filial=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaEspessura($params){
    $tsql = "exec consulta_espessura @empresa=?, @filial=?, @grupo=?, @familia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaHistoricoPreco($params){
    $tsql = "exec consulta_histprecovenda @empresa=?, @filial=?, @familia=?, @grupo=?, @qualidade=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


function spConsultaCliforCompra($params){
    $tsql = "exec consulta_clifor_compra @empresa=?, @filial=?, @codigo=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaOrdemCompra($params){
    $tsql = "exec consulta_ordemcompra @empresa=?, @filial=?, @numoc=?, @produto=?, @fornecedor=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaProdutoCompra($params){
    $tsql = "exec consulta_produto_compra @empresa=?, @filial=?, @codigo=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


/**
 * NOTAS DE ENTRADA
*/
function spConsultaNotasRecebidas($params){
    $tsql = "exec consulta_notasrecebidas @nota=?, @cnpj=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotasEntrada($params){
    $tsql = "exec consulta_notas_entrada_dev @empresa=?, @filial=?, @codigo=?, @nota=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaItemNotas($params){
    $tsql = "exec consulta_item_notas_dev @empresa=?, @filial=?, @nota=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotasEmitidas($params){
    $tsql = "exec consulta_notasemitidas @nota=?, @cnpj=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotasSaida($params){
    $tsql = "exec consulta_notas_saida @empresa=?, @filial=?, @nota=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaItemNotasSaida($params){
    $tsql = "exec consulta_item_notas_saida @empresa=?, @filial=?, @nota=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaReceberDevolucao($params){
    $tsql = "exec consulta_recebe_devolucao @empresa=?, @filial=?, @nota=?, @codigo=?, @serie=?, @especie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaVolumeDevolucao($params){
    $tsql = "exec consulta_volumes_devolucao @empresa=?, @filial=?, @nota=?, @codigo=?, @especie=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spGeraNfeDevolucao($params){
    $tsql = "exec gera_nfe_devolucao @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?, @vuf=?, @tipoamb=?, @finalidade=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;    
}

function spConsultaPesos($params){
    $tsql = "exec consulta_pesos @empresa=?, @filial=?, @codigo=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['pesobruto'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr; 
}

function spConsultaTipoFrete($params){
    $tsql = "exec consulta_tipofrete @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


function spConsultanaturezaEntra($params){
    $tsql = "exec consulta_naturezas_entra @empresa=?, @filial=?, @uf=?, @vuf=?, @transacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaPagarDev($params){
    $tsql = "exec consulta_pagar_dev @empresa=?, @filial=?, @codigo=?, @nota=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultavolumesAnalizados($params){
    $tsql = "exec consulta_volumes_analizado @empresa=?, @filial=?, @nota=?, @item=?, @serie=?, @especie=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spGeraNfEletronica($params){
    sqlsrv_configure('WarningsReturnAsErrors',0);
    $tsql = "exec gera_nf_eletronica @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?, @vuf=?, @tipoamb=?, @finalidade=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);
    
    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

/**
* FIM CONSULTA NOTA
*/


// MAQUINAS

function spConsultaGrupoMaquina($params){
    $tsql = "exec consulta_grupo_maquinas @empresa=?, @filial=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

/**
 * DASHBOARD COTACAO DE VENDAS
*/

function spGeraIndicaCotacaoBloq($params){
    $tsql = "exec gera_indica_cotacao_bloqueios @empresa=?, @filial=?, @usuario=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function soMostraIndicaCotacaoBloq($params){
    $tsql = "exec mostra_indica_cotacao_bloqueios @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spMostraIndicaCotacaoVendas($params){
    $tsql = "exec mostra_indicacotacaovendas @empresa=?, @filial=?, @usuario=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spGeraIndicaCotacaoVendas($params){
    $tsql = "exec gera_indicacotacaovendas @empresa=?, @filial=?, @usuario=?, @bloqueio=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spMostraCotacaoVendaBloq($params){
    $tsql = "exec mostra_cotacaovenda_bloqueadas @empresa=?, @filial=?, @usuario=?, @bloqueio=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaCliforCotacaoBloq($params){
    $tsql = "exec consulta_clifor_cotacao_bloq @empresa=?, @filial=?, @bloqueio=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaCliforVendedor($params){
    $tsql = "exec consulta_clifor_vendedor @empresa=?, @filial=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


function spLiberaCotacaoVenda ($params) {
    $tsql = "exec libera_cotacaovenda @empresa=?, @filial=?, @codigo=?, @numero=?, @versao=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spGeraIndicaCotacaoLiberada ($params) {
    $tsql = "exec gera_indica_cotacao_liberadas @empresa=?, @filial=?, @usuario=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spGeraIndicaCotacaoVendasLiberada ($params) {
    $tsql = "exec gera_indicacotacaovendasliberadas @empresa=?, @filial=?, @usuario=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spMostraIndicaCotacaoVendasLiberada ($params) {
    $tsql = "exec mostra_indicacotacaovendasliberadas @empresa=?, @filial=?, @usuario=?, @vendedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/**
 * FIM DASHBOARD COTACAO
*/


function spConsultaMotivos($params){
    $tsql = "exec consulta_motivos @motivo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}


function spConsultaNotaSaida($params){
    $tsql = "exec consulta_notasaida @empresa=?, @filial=?, @nota=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotaSaidaItem($params){
    $tsql = "exec consulta_notasaidaitem @empresa=?, @filial=?, @nota=?, @codigo=?, @especie=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotaEntrada($params){
    $tsql = "exec consulta_notaentrada @empresa=?, @filial=?, @nota=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaNotaEntraItem($params){
    $tsql = "exec consulta_notasentraitem @empresa=?, @filial=?, @nota=?, @codigo=?, @especie=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

//FATURAMENTO POR LOTE

function spConsultaCliFaturar($params) {
    $tsql = "exec consulta_cliente_faturar @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFaturar($params) {
    $tsql = "exec consulta_faturar @empresa=?, @filial=?, @codigo=?, @venda=?, @item=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaVolumeFaturar($params) {
    $tsql = "exec consulta_volumes_faturar @empresa=?, @filial=?, @codigo=?, @venda=?, @item=?, @volume=?, @ordem=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFinalidade($params) {
    $tsql = "exec consulta_finalidades @empresa=?, @filial=?, @finalidade=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/**
 * Entrada de Notas
 */
function sp_ConsultaNotasEntrada($params) {
    $tsql = "exec consulta_notas_entrada @empresa=?, @filial=?, @codigo=?, @nota=?, @especie=?, @serie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaOrdemCompNota($params) {
    $tsql = "exec consulta_ordemcomp_nota @empresa=?, @filial=?, @numoc=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


//Faturamento sem produto
function spConsultaProdutoAlmoxarifado($params) {
    $tsql = "exec consulta_produto_almoxarifado @empresa=?, @filial=?, @codint=?, @produto=?, @codext=?, @grupo=?, @familia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//ORDEM DE VENDA
function spGera_indicavenda($params) {
    $tsql = "EXEC gera_indica_venda @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spMostra_indicavenda($params) {
    $tsql = "exec mostra_indicavenda @empresa=?, @filial=?, @grupo=?, @familia=?, @usuario=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsulta_indicadorvendas($params) {
    $tsql = "exec consulta_indicadorvendas @empresa=?, @filial=?, @grupo=?, @familia=?, @med1=?, @promotor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


/**
* Maquinas CONSULTA
*/ 
function spConsultaMaquinasAco($params) {
    $tsql = "exec consulta_maquinas_aco @empresa=?, @filial=?, @maquina=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheFerram($params) {
    $tsql = "exec consulta_detalheferram @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheMatp($params) {
    $tsql = "exec consulta_detalhematp @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDetalheMaqui($params) {
    $tsql = "exec consulta_detalhemaqui @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaImagemMaq($params) {
    $tsql = "exec consulta_imagemmaq @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFolgaFacas($params) {
    $tsql = "exec consulta_folgafacas @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/**
 * Liberacao Ordem Producao
*/
function sp_ConsultaDesvios($params) {
    $tsql = "exec consulta_desvios @empresa=?, @filial=?, @venda=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function sp_ItemDesvios($params) {
    $tsql = "exec consulta_item_desvios @empresa=?, @filial=?, @venda=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

/**
 * Materiais
 */
function spConsultaEntradas($params){
    $tsql = "exec consulta_entradas @empresa=?, @filial=?, @dataini=?, @datafim=?, @volume=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaSaidas($params){
    $tsql = "exec consulta_saidas @empresa=?, @filial=?, @dataini=?, @datafim=?, @nota=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Operador de Maquina
function spConsultaOperadorMaquina($params){
    $tsql = "exec consulta_operador_maquina @empresa=?, @filial=?, @operador=?, @maquina=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaHistOperadorMaquina($params){
    $tsql = "exec consulta_hist_operador_maquina @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//HOMOLOGACAO
function spConsultaHomologados($params){
    $tsql = "exec consulta_homologados @empresa=?, @filial=?, @produto=?, @codfor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


//Ordem de Producao
function spConsultaProgramacoes($params){
    $tsql = "exec consulta_programacoes @empresa=?, @filial=?, @programacao=?, @venda=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaExcluirProgramacoes($params){
    $tsql = "exec consulta_excluir_programacoes @empresa=?, @filial=?, @programacao=?, @venda=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Embalagem
function spConsultaProdutosEmbalagens($params){
    $tsql = "exec consulta_produto_embalagens @empresa=?, @filial=?, @codint=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Inicializao OP
function spConsultaProgramacaoInicProd($params){
    $tsql = "exec consulta_programacao_inicprod @empresa=?, @filial=?, @numero=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaoInicProd($params){
    $tsql = "exec consulta_inicprod @empresa=?, @filial=?, @nrop=?, @sequencia=?, @usuario=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spAnalisaMaquinas($params){
    $tsql = "exec analisa_maquinas @empresa=?, @filial=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaParada($params){
    $tsql = "exec consulta_parada @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Cotacao File
function spConsultaDocCotacaoVenda($params){
    $tsql = "exec consulta_doccotacaovenda @empresa=?, @filial=?, @cotacao=?, @sequencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Venda File
function spConsultaDocVenda($params){
    $tsql = "exec consulta_docvenda @empresa=?, @filial=?, @venda=?, @sequencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Cotacao Compra File
function spConsultaDocCotacaoCompra($params){
    $tsql = "exec consulta_doccotacaocompra @empresa=?, @filial=?, @cotacao=?, @sequencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Ind. Ordem de Venda
function spGeraIndicaVendas($params){
    $tsql = "exec gera_indica_vendas @empresa=?, @filial=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

//Saldo Bancario
function spConsultaSaldoBanco($params){
    $tsql = "exec consulta_saldo_banco @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?, @dtsaldo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaApagar($params) {
    $tsql = "exec consulta_apagar @empresa=?, @filial=?, @codigo=?, @nota=?, @item=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['datapagto'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Documentacao Ficha Tecnica
function spConsultaDocFichaTecnica($params){
    $tsql = "exec consulta_docfichatecnica @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @sequencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Observacao ficha tecnica
function spConsultaObsFichaTec($params){
    $tsql = "exec consulta_obsfichatec @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @sequencia=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Conciliacao Bancaria
function spGeraConciliacao($params){
    $tsql = "exec gera_conciliacao @empresa=?, @filial=?, @dataini=?, @datafim=?, @usuario=?, @banco=?, @agencia=?, @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaConciliacao($params){
    $tsql = "exec consulta_conciliacao @empresa=?, @filial=?, @dataini=?, @datafim=?, @banco=?, @agencia=?, @conta=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaTotaisConciliacao($params){
    $tsql = "exec consulta_totais_conciliacao @empresa=?, @filial=?, @dataini=?, @datafim=?, @banco=?, @agencia=?, @conta=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaEmAberto($params){
    $tsql = "exec consulta_emaberto @empresa=?, @filial=?, @dataini=?, @datafim=?, @banco=?, @agencia=?, @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['receberemaberto'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaAlcadas($params){
    $tsql = "exec consulta_alcadas @empresa=?, @filial=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaLiberaBanco($params){
    $tsql = "exec consulta_libera_banco @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spConsultaSaldoConciliacao($params){
    $tsql = "exec consulta_saldo_conciliacao @empresa=?, @filial=?, @dataini=?, @datafim=?, @banco=?, @agencia=?, @conta=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['Pagamentos'] = $valor;

    $resultado = sqlsrv_next_result($stmt);
    while ($row = sqlsrv_fetch_array($stmt)) {
        $valor[] = $row;
    }
    $arr['saldoAtual'] = $valor;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaFichaRecusada($params){
    $tsql = "exec consulta_ficha_recusada @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// Consulta Tipo de Documento
function spConsultaTipoDoc($params){
    $tsql = "exec consulta_tipodoc @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaCampoTipoDoc($params){
    $tsql = "exec consulta_campotipodoc @campo=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaDocClifor($params){
    $tsql = "exec consulta_doc_clifor @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaMaquinasGrupo($params){
    $tsql = "exec consulta_maquinas_grupo @empresa=?, @filial=?, @grupo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

// ORDEM DE PRODUCAO
function spConsultaVendaSucata($params){
    $tsql = "exec consulta_vendasucata @empresa=?, @filial=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spConsultaPacotes($params){
    $tsql = "exec consulta_pacotes @empresa=?, @filial=?, @numero=?, @volume=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}


function spRelatorioProgramacao ($params) {
    $tsql = "exec relatorio_programacao @empresa=?, @filial=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spRelatorioPlanoCorte ($params) {
    $tsql = "exec relatorio_planocorte @empresa=?, @filial=?, @numero=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spRelatorioPlanoCorteChapa ($params) {
    $tsql = "exec relatorio_planocorte_chapa @empresa=?, @filial=?, @numero=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaPacotes2 ($params) {
    $tsql = "exec consulta_pacotes2 @empresa=?, @filial=?, @numero=?, @venda=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsulta_PlanoCorte($params) {
    $tsql = "exec consulta_planocorte @empresa=?, @filial=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsulta_ItemPlanoCorte($params) {
    $tsql = "exec consulta_itemplanocorte @empresa=?, @filial=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaPlanoCorteChapa($params) {
    $tsql = "exec consulta_planocorte_chapa @empresa=?, @filial=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaProgramacoesApontamento($params) {
    $tsql = "exec consulta_programacoes_apontamento @empresa=?, @filial=?, @programacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}

function spConsultaInstrumentos($params) {
    $tsql = "exec consulta_instrumentos @empresa=?, @filial=?, @codigo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        array_push($result,$row);
    }
    $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;  
}





