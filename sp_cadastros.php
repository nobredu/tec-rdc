<?php
// include $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/restrito.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/conn2.php';

ini_set("memory_limit","1024M");


/*
** Menus & Modulos
*/

function spCriaMenu($params) {
    $tsql = "EXEC cria_menu_usuario @perfil=?, @programa=?, @opcao=?, @empresa=?, @filial=?, @modulo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaModulo($params) {
    $tsql = "EXEC cria_modulos @modulo=?, @moddesc=?, @resumo=?, @empresa=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaPrograma($params) {
    $tsql = "EXEC cria_programas @programa=?, @ativo=?, @descricao=?, @progdesc=?, @diretorio=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Usuarios
*/

function spCriaUsuario($params) {
    $tsql = "EXEC cria_usuario @userid=?, @usuario=?, @empresa=?, @filial=?, @usunome=?, @vendedor=?, @usutipo=?, @email=?, @perfil=?, @mudafil=?, @senha=?, @promotor=?, @dashboard=?, @codvend=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Empresa & Filial
*/

function spCriaEmpresa($params) {
    $tsql = "EXEC cria_empresa @empresa=?, @razao=?, @dataabertura=?, @natureza=?, @percpis=?, @percsocial=?, @ativprinc=?, @descativ1=?, @ativsec=?, @descativ2=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaFilial($params) {
    $tsql = "EXEC cria_filial @empresa=?, @filial=?, @razao=?, @endereco=?, @bairro=?, @municipio=?, @uf=?, @cep=?, @cnpj=?, @inscricao=?, @email=?, @telefone=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function spAltFornecedor($params) {
    $tsql = "EXEC altera_fornecedor @tipo=?, @razao=?, @fantasia=?, @cnpj=?, @endereco=?, @numero=?, @complemento=?, @cep=?, @bairro=?, @municipio=?, @uf=?, @telefone=?, @celular=?, @responsavel=?, @email=?, @inscricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function salvarImg($img,$pasta,$nomeFinal) {
    // diretorio onde a imagem vai ser salva
    $_UP['pasta'] = $pasta.'/';

    // tamanho maximo do arquivo
    $_UP['tamanho'] = 1024 * 1024 * 2; //2Mb

    // extenções permitidas
    $_UP['extensoes'] = ['jpg', 'png', 'gif'];


    // erros possiveis
    $_UP['erros'][0] = 'Não houve erro';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if($img['imagem']['error'] != 0) {
        $resultImg = "Não foi possivel fazer o upload, erro:<br />" . $_UP['erros'][$img['imagem']['error']];
    }

    // verifica a extensão do arquivo
    $extensao = explode('.', $img['imagem']['name']);
    $extensao = strtolower(end($extensao));
    if (array_search($extensao, $_UP['extensoes']) === false) {
        $resultImg = "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
    }

    // verifica o tamanho da imagem
    else if ($_UP['tamanho'] < $img['imagem']['size']) {
         $resultImg = "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
    }

    // move para a pasta
    else {
        if (move_uploaded_file($img['imagem']['tmp_name'], $_UP['pasta'] . $nomeFinal)) {
            $resultImg = "sucesso";
        } else {
            $resultImg = "erro";
        }
    }

    return $resultImg;
}

function gravaCaptura($img,$dir,$nomeFinal) {
    $result = [];
    $data = str_replace(" ","+",$img);
    $path = $dir."/{$nomeFinal}";

    //data
    $data = explode(',', $data);

    //Save data
    file_put_contents($path, base64_decode(trim($data[1])));
}




/*
** Bryan
*/




// Cadastro de aprovação dos itens da Ordem de Compra

function spCadastrodeItensdeCompras($params) {
    $tsql = "exec aprova_item_ordcomp @empresa=?, @filial=?, @numoc=?, @item=?, @qtdprod=?, @aprovacao=?, @usuario=?, @versao=?, @vlrtotit=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Cadastro de aprovação das Ordems de Compra

function spCadastrodeOrdemCompras($params) {
    $tsql = "exec aprova_ordcomp @empresa=?, @filial=?, @numoc=?, @aprovacao=?, @usuario=?, @versao=?, @versaonova=?, @alterada=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCadastrodeItensdeComprasTotal($params) {
    $tsql = "exec aprova_item_ordcomp_total @empresa=?, @filial=?, @numoc=?, @item=?, @qtdprod=?, @aprovacao=?, @usuario=?, @versao=?, @vlrtotit=?, @alterada=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);  
}

function spCriaAvalicoesEmpresa ($params) {
    $tsql = "exec cria_avaliacoes @empresa=?, @filial=?, @descricao=?, @valor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    sqlsrv_next_result($stmt);
    $result = [sqlsrv_next_result($stmt)];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spCriaTipoCliFor ($params) {
    $tsql = "exec cria_tipoclifor @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    sqlsrv_next_result($stmt);
    $result = [sqlsrv_next_result($stmt)];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spCriaAplicacaoProdutos ($params) {
    $tsql = "exec cria_aplicacoes @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    sqlsrv_next_result($stmt);
    $result = [sqlsrv_next_result($stmt)];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spCriaSeries($params) {
    $tsql = "exec cria_series @empresa=?, @filial=?, @serie=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaCodigoClassificacaoFiscais($params) {
    $tsql = "exec cria_clafisc @codccf=?, @ccf=?, @cop=?, @percipi=?, @ccfdesc=?, @percicmt=?, @decretoipi=?, @icmsfederal=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spGeraSaldo($params) {
    $tsql = "exec gera_saldos2 @empresa=?,@filial=?,@cliente=?,@dtinicio=?,@dtfim=?,@usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaResultadoEDI($params) {
    $tsql = "exec cria_resultedi3 @empresa=?,@filial=?,@fabrica=?,@usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaFerramenta($params) {
    $tsql = "exec cria_ferramenta @empresa=?, @filial=?, @codext=?, @codigo=?, @codop=?, @dtaprova=?, @tipo=?, @grupo=?, @codccf=?, @local=?, @local2=?, @batidas=?, @galpao=?, @ordserv=?, @usuario=?, @observa=?, @preventiva=?, @acumulado=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaProdutos ($params) {
    $tsql = "exec cria_produtos @empresa=?, @filial=?, @codint=?, @codext=?, @tba=?, @indpeso=?, @tppro=?, @unidade=?, @codccf=?, @grupo=?, @familia=?, @descricao=?, @med1=?, @med2=?, @med3=?, @quali=?, @ativo=?, @pemetro=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    $result = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;
}

function spCriaCliFor ($params) {
    $tsql = "exec cria_clifor @empresa=?, @filial=?, @tipo=?, @tipopessoa=?, @razao=?, @fantasia=?, @cnpj=?, @inscricao=?, @endereco=?, @numero=?, @complemento=?, @cep=?, @bairro=?, @municipio=?, @uf=?, @telefone=?, @celular=?, @responsavel=?, @email=?, @ramo=?, @setor=?, @contribui=?, @avaliacao=?, @codfil=?, @codmunic=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if($stmt === false) {
        print_r(sqlsrv_errors());
        die(formatErrors(sqlsrv_errors()));
    }
    sqlsrv_next_result($stmt);
    $result = [sqlsrv_next_result($stmt)];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($result,$row);
        }
        $arr = $result;

    sqlsrv_free_stmt($stmt);
    return $arr;     
}

function spCriaCobranca ($params) {
    $tsql = "exec cria_cobrancas @empresa=?, @filial=?, @codigo=?, @endereco=?, @numero=?, @complemento=?, @cep=?, @bairro=?, @cidade=?, @codmuni=?, @uf=?, @telefone=?, @celular=?, @email=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaContatos ($params) {
    $tsql = "exec cria_contatos @empresa=?, @filial=?, @codigo=?, @vendedor=?, @assistente=?, @telefone=?, @celular=?, @email=?, @emailnfe=?, @responsavel=?, @telresp=?, @celresp=?, @emailresp=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDadosAdicionais ($params) {
    $tsql = "exec cria_adicionais @empresa=?, @filial=?, @codigo=?, @certificado=?, @fichatecnica=?, @romaneio=?, @reduzipi=?, @suframa=?, @abate=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaAvaliacaoClifor ($params) {
    $tsql = "exec cria_avaliaclifor @empresa=?, @filial=?, @codigo=?, @datafundacao=?, @jucesp=?, @datacapital=?, @capitalsocial=?, @dataavaliacao=?, @avaliacao=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaPrecoDeVenda ($params) {
    $tsql = "exec cria_precovenda @empresa=?, @filial=?, @grupo=?, @familia=?, @espessurade=?, @espessurate=?, @custousina=?, @qualidade=?, @valor1=?, @valor2=?, @usuario=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql, $params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


/*
** Ficha Técnica
*/
function spCriaFicha($params) {
    $tsql = "exec cria_fichatec @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @med1min=?, @med1max=?, @med2min=?, @med2max=?, @med3min=?, @med3max=?, 
    @dni=?, @dti=?, @dnimax=?, @dne=?, @dte=?, @dnemax=?, @revesti=?, @microns=?, @gm2=?, @tprevesti=?, @embalagem=?, @pesoro=?, @pesoam=?, @qtdeam=?, @med1=?, @med2=?, @med3=?, @dtcad=?, @usuario=?, 
    @superficie=?, @aplicacao=?, @descricao=?, @dureza=?, @tracao=?, @escoa=?, @alonga=?, @norma=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
        // return false;
    }
    sqlsrv_free_stmt($stmt);  
}

function spCriaHistProd($params) {
    $tsql = "exec cria_fichaproh @empresa=?, @filial=?, @codigo=?, @produto=?, @referencia=?, @obspro=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaNormas($params) {
    $tsql = "exec cria_normasp @empresa=?, @filial=?, @norma=?, @item=?, @ordem=?, @codigo=?, @produto=?, @referencia=?, @minimo=?, @maximo=?, @peso=?, @bitola=?, @espessuramin=?, @espessuramax=?, @usuario=?, @versao=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaObsCli($params) {
    $tsql = "exec cria_obsclificha @empresa=?, @filial=?, @codigo=?, @ficha=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaObsFicha($params) {
    $tsql = "exec cria_fichaprog @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @observacao=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaObsProd($params) {
    $tsql = "exec cria_fichaproo @empresa=?, @filial=?, @codigo=?, @produto=?, @referencia=?, @obspro=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaOrdemVenda($params) {
    $tsql = "exec cria_vendasc @empresa=?, @filial=?, @venda=?, @consumo=?, @especie=?, @transp=?, @prazo=?, @fretecf=?, @modali=?, @comissao=?, @comissaoa=?, @vendedor=?, @promotor=?, @codigo=?, @pedemp=?, @perccom=?, @perccoma=?, @percdesc=?, @liberacao=?, @dtlibera=?, @usuario=?, @imprime=?, @obscli=?, @endent=?, @tipoped=?, @triangular=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaOrdemVendaItens($params) {
    $tsql = "exec cria_vendasi @empresa=?, @filial=?, @venda=?, @item=?, @sitpreco=?, @natureza=?, @produto=?, @percicm=?, @percipi=?, @qtvolume=?, @qtvenda=?, @vlunitario=?, @descricao=?, @obsite=?, @dtentrega=?, @referencia=?, @itemped=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spLiquidaVenda($params) {
    $tsql = "EXEC liquida_vendas @empresa=?, @filial=?, @codigo=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function spLiberaOrdemVenda($params) {
    $tsql = "exec libera_vendasc @empresa=?, @filial=?, @codigo=?, @numero=?, @tipo=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}
/*
** Elementos
*/
function spCriaElementos($params) {
    $tsql = "exec cria_elementos @codigo=?, @elemento=?, @descelemento=?, @grupo=?, @tipoelemento=?, @bitola=?, @peso=?;";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Normas
*/
function spCriaNormasAbnt($params) {
    $tsql = "exec cria_normas @empresa=?, @filial=?, @descricao=?, @grau=?, @revisao=?, @usuario=?, @dtini=?, @dtfim=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Ficha Empresa
*/
function spCriaFichaEmpresa($params) {
    $tsql = "exec cria_fichas @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Ficha Historico
*/
function spCriaFichaHistorico($params) {
    $tsql = "exec cria_fichahis @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Ficha Obervação
*/
function spCriaFichaObsProd($params) {
    $tsql = "exec cria_fichaobs @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Certificado
*/
function spCriaCertificado($params) {
    $tsql = "exec cria_certificados @empresa=?, @filial=?, @inspecao=?, @produto=?, @dtinspe=?, @dimensao=?, @norma=?, @cdnorma=?, @volume=?, @ordem=?, @pefat=?, @usuario=?, @impre=?, @tempe=?, @ef_le=?, @ef_lr=?, @ef_al=?, @ef_du=?, @ef_em=?, @rev=?, @cq_c=?, @cq_si=?, @cq_mn=?, @cq_p=?, @cq_s=?, @cq_al=?, @cq_cu=?, @cq_nb=?, @cq_v=?, @cq_ti=?, @cq_cr=?, @cq_ni=?, @cq_mo=?, @cq_w=?, @cq_pb=?, @cq_mg=?, @cq_b=?, @cq_sn=?, @cq_zn=?, @cq_as=?, @cq_bi=?, @cq_ca=?, @cq_ce=?, @cq_zr=?, @cq_la=?, @cq_fe=?, @cq_co=?, @an_r=?, @an_n=?, @an_ar=?, @dtana=?, @du_hc=?, @grao=?, @inctipo=?, @inccampo=?, @incserie=?, @dmandril=?, @dbangulo=?, @dbscorpo=?, @dbaval=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Ficha Obervação
*/
function spCriacaoModulo($params) {
    $tsql = "exec cria_modulo @empresa=?, @filial=?, @modulo=?, @descricao=?, @resumo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


/*
** Cotacao
*/
function spCriaCotacao($params) {
    $tsql = "exec cria_cotacao @empresa=?, @filial=?, @usuario=?, @ccusto=?, @observacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
        // return false;
    }
    sqlsrv_free_stmt($stmt);  
}

function spCriaItemCotacao($params) {
    $tsql = "exec cria_itemcotacao @empresa=?, @filial=?, @numcotacao=?, @codprod=?, @itemcotacao=?, @qtdprod=?, @unimed=?, @observacao=?, @qtdped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
        // return false;
    }
    sqlsrv_free_stmt($stmt);  
}

function Venda($params) {
    $tsql = "exec cria_itemcotacao @empresa=?, @filial=?, @numcotacao=?, @codprod=?, @itemcotacao=?, @qtdprod=?, @unimed=?, @observacao=?, @qtdped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spEnviaCotacao($params) {
    $tsql = "exec envio_cotacao @empresa=?, @filial=?, @numcotacao=?, @fornecedor=?, @percicms=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spLancarCotacao($params) {
    $tsql = "exec lancar_cotacao @empresa=?, @filial=?, @numcotacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovaItemCotacao($params) {
    $tsql = "exec aprova_itemcotacao @empresa=?, @filial=?, @numcotacao=?, @itemcotacao=?, @fornecedor=?, @aprovacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovaFornecCotacao($params) {
    $tsql = "exec aprova_forn_itemcotacao @empresa=?, @filial=?, @numcotacao=?, @fornecedor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovaCotacao($params) {
    $tsql = "exec aprova_cotacao @empresa=?, @filial=?, @numcotacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCancelaCotacao($params) {
    $tsql = "exec cancela_cotacao @empresa=?, @filial=?, @numcotacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spReabreCotacao($params) {
    $tsql = "exec reabre_cotacao @empresa=?, @filial=?, @numcotacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


/*
** Ordem de Pagamento
*/
function spIncluiPagamento($params) {
    $tsql = "exec inclui_pagamento @empresa=?, @filial=?, @cobra=?, @venda=?, @ordem=?, @codigo=?, @historico=?, @dtnota=?, @dtv=?, @dtm=?, @dtlanca=?,
        @vltotaln=?, @descontos=?, @juros=?, @vlcorrigido=?, @vlsaldo=?, @especie=?, @banco=?, @agencia=?, @conta=?, @observacao=?, @serie=?, @ccusto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Desdobramento de Duplicatas
*/
function spIncluirRecebimento($params) {
    $tsql = "exec inclui_recebimento @empresa=?, @filial=?, @cobra=?, @venda=?, @ordem=?, @codigo=?, @historico=?, @dtnota=?, @dtv=?, @dtm=?, @dtlanca=?, @vltotaln=?, @vlrecebe=?, @descontos=?, @juros=?, @vlcorrigido=?, @vlsaldo=?, @especie=?, @banco=?, @agencia=?, @conta=?, @observacao=?, @serie=?, @nrobanco=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaRecebimentos($params) {
    $tsql = "exec baixa_recebimentos @empresa=?, @filial=?, @nota=?, @ordem=?, @codigo=?, @dtpagamento=?, @historico=?, @vlpago=?, @vljuros=?, @vldesconto=?, @vlsaldo=?, @serie=?, @especie=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaLoteSaida($params) {
    $tsql = "exec baixalote_saida @empresa=?, @filial=?, @volume=?, @ordem=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spIncluiAReceber($params) {
    $tsql = "exec inclui_areceber @empresa=?, @filial=?, @cobra=?, @venda=?, @ordem=?, @codigo=?, @historico=?, @dtnota=?, @dtv=?, @dtm=?, @dtrecebe=?, @dtlanca=?, @vltotaln=?, @vlrecebe=?, @descontos=?, @juros=?, @vlcorrigido=?, @vlsaldo=?, @especie=?, @banco=?, @agencia=?, @conta=?, @observacao=?, @serie=?, @nrobanco=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


/*
** Banco
*/

function spCriaBanco($params) {
    $tsql = "exec cria_banco @empresa=?, @filial=?, @banco=?, @modelo=?, @mora=?, @diaspro=?, @instrucao=?, @instrucao1=?, @espes=?, @carteira=?, @transa=?,
        @baconta=?, @babrev=?, @baagencia=?, @banomeage=?, @banome=?, @baendereco=?, @conta=?, @cheque=?, @documento=?, @agencia=?, @convenio=?, @codemp=?, @saldo=?, @dtsaldo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVenci($params) {
    $tsql = "exec cria_vencicomp @empresa=?, @filial=?, @nota=?, @ordem=?, @codigo=?, @tr=?, @serie=?, @instrucao=?, @instrucao1=?, @espes=?, @carteira=?, @transa=?, @diaspro=?, @avalista=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/*
** Cadastros Gerais do Sistema
*/
function spCriaCartaCorrecao($params) {
    $tsql = "exec cria_carta_correcao @empresa=?, @filial=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaCodigoComissao($params) {
    $tsql = "exec cria_codigocomissao @codigo=?, @percent=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDespesas($params) {
    $tsql = "exec cria_despesas @codigo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaCodigoIcms($params) {
    $tsql = "exec cria_codcsticms @origem=?, @descorigem=?, @codigo=?, @desctributa=?, @csticms=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaCodigoIpi($params) {
    $tsql = "exec cria_codcstipi @codigo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaCodigoPisCofins($params) {
    $tsql = "exec cria_codcstpiscofins @codigo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaQualidadeProd($params){
    $tsql = "exec cria_qualidades @empresa=?, @filial=?, @codigo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaRamos($params){
    $tsql = "exec cria_ramos @empresa=?, @filial=?, @setor=?, @ramo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaSetor($params){
    $tsql = "exec cria_setores @empresa=?, @filial=?, @setor=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaTipoProd($params){
    $tsql = "exec cria_tipoproduto @codigo=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaFamilia($params){
    $tsql = "exec cria_familias @empresa=?, @filial=?, @codigo=?, @abreviacao=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaGrupo($params){
    $tsql = "exec cria_grupos @empresa=?, @filial=?, @grupo=?, @abreviacao=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVendedor($params){
    $tsql = "exec cria_vendedores @empresa=?, @filial=?, @tipo=?, @nome=?, @perccom=?, @percmin=?, @percmax=?, @calccom=?, @codfor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaPrazo($params){
    $tsql = "exec cria_prazos @empresa=?, @filial=?, @prazo=?, @tipo=?, @parcelas=?, @vencimentos=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaPrazoDias($params){
    $tsql = "exec cria_diasdeprazo @empresa=?, @filial=?, @prazo=?, @ordem=?, @dias=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaFiliais($params) {
    $tsql = "EXEC cria_filiais @empresa=?, @filial=?, @razao=?, @endereco=?, @bairro=?, @municipio=?, @uf=?, @cep=?, @cnpj=?, @inscricao=?, @email=?, @telefone=?, @emailcompras=?, @tecnico1=?, @cargo1=?, @email1=?, @tecnico2=?, @cargo2=?, @email2=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaHistoricos($params){
    $tsql = "exec cria_historicos @codigo=?, @descricao=?, @tipo=?, @lanca=?, @conta=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaLivro($params){
    $tsql = "exec cria_livros @empresa=?, @filial=?, @can=?, @situacao=?, @natureza=?, @codfor=?, @nota=?, @dtentrada=?, @dtnota=?, @especie=?, @uf=?, @percicm=?, @serie=?, @vltotaln=?, @vlbaseicm=?, @vlicm=?, @vlbaseipi=?, @vlipi=?, @vloicm=?, @vliicm=?, @vloipi=?, @vliipi=?, @percsoma=?, @observa=?, @emitente=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaNaturezas($params){
    $tsql = "exec cria_naturezas @empresa=?, @filial=?, @natureza=?, @natdesc=?, @natabrev=?, @imobilizado=?, @icmipi=?, @tribicm=?, @tribipi=?, @tbb=?, @faturar=?, @vlcontabil=?, @tr=?, @nat0=?, @reducao=?, @nat1=?, @nat2=?, @decretoipi=?, @decretoicm=?, @tr1=?, @natu=?, @CST_IPI=?, @cst_icms=?, @cst_pis=?, @descenquadraipi=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function spCriaNormasI($params){
    $tsql = "exec cria_normasi @empresa=?, @filial=?, @norma=?, @item=?, @minimo=?, @maximo=?, @peso=?, @bitola=?, @medmin=?, @medmax=?, @usuario=?, @dtproc=?, @status=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaMedidasLote($params){
    $tsql = "exec inclui_medidas_lote @empresa=?, @filial=?, @volume=?, @ordem=?, @venda=?, @item=?, @med1=?, @med2=?, @med3=?, @alocacao=?, @peso=?, @altfardo=?, @diamint=?, @diamext=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVolumesConforme($params){
    $tsql = "exec cria_volumes_conforme @empresa=?, @filial=?, @produto=?, @volume=?, @ordemant=?, @peso=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/**
* Cotacao de Vendas
*/
function spCriaCotacaoVenda($params) {
    $tsql = "exec cria_cotacaovenda @empresa=?, @filial=?, @codigo=?, @vendedor=?, @promotor=?, @especie=?, @prazo=?, @transp=?, @frete=?, @modalidade=?, @triangular=?, @endentrega=?, @numped=?, @valortotal=?, @observacao=?, @liberacao=?, @consumo=?, @tipoped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);  
}

function spCriaItemCotacaoVenda($params){
    $tsql = "exec cria_itemcotacaovenda @empresa=?, @filial=?, @cotacao=?, @item=?, @itemped=?, @produto=?, @refere=?, @dtentrega=?, @natureza=?, @quantidade=?, @unidade=?, @valorunitario=?, @observacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovaCotacaoVenda($params){
    $tsql = "exec aprova_cotacaovendas @empresa=?, @filial=?, @codigo=?, @cotacao=?, @versao=?, @venda=?, @numped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovItemCotacaoVenda($params){
    $tsql = "exec aprova_itemcotacaovenda @empresa=?, @filial=?, @cotacao=?, @item=?, @versao=?, @itemped=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVendaCotacao($params){
    $tsql = "exec cria_vendasc_cotacao @empresa=?, @filial=?, @cotacao=?, @venda=?, @consumo=?, @comissao=?, @comissaoa=?, @perccom=?, @perccoma=?, @percdesc=?, @usuario=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVendaItemCotacao($params){
    $tsql = "exec cria_vendasi_cotacao @empresa=?, @filial=?, @cotacao=?, @venda=?, @item=?, @refere=?, @dtped=?, @percicm=?, @percipi=?, @descricao=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}
/**
* Fim Cotacao Venda
*/

/**
* Cadastro de maquinas
*/
function spCriaGrupoMaquinasAco($params){
    $tsql = "exec cria_grupo_maquinas_aco @empresa=?, @filial=?, @descricao=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}
/**
* Cadastro de maquinas
*/


/**
* Cadastro de Notas
*/
function spCriaNotaEntraDev($params){
    $tsql = "exec cria_notaentra_dev @empresa=?, @filial=?, @codigo=?, @notasai=?, @dtproc=?, @usuario=?, @especie=?, @especiesai=?, @serie=?, @seriesai=?, @idnfe=? ";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);      
}

function spCriaNotaEntraItemDev($params){
    $tsql = "exec cria_notaentraitem_dev @empresa=?, @filial=?, @nota=?, @item=?, @notasai=?, @dtproc=?, @usuario=?, @especie=?, @especiesai=?, @natureza=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaLivrosEdv($params){
    $tsql = "exec cria_livros_edv @empresa=?, @filial=?, @codfor=?, @nota=?, @notasai=?, @dtentrada=?, @natureza=?, @dtnota=?, @especie=?, @serie=?, @especiesai=?, @seriesai=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaComplNota($params){
    $tsql = "exec cria_complnota @empresa=?, @filial=?, @nota=?, @serie=?, @especie=?, @codigo=?, @pesobruto=?, @pesoliquido=?, @qtvolume=?, @observacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVolumesDev($params){
    $tsql = "exec cria_volumes_dev @empresa=?, @filial=?, @nota=?, @item=?, @notaentra=?, @especie=?, @especieentra=?, @serie=?, @serieentra=?, @codigo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAtualizaSaldos($params){
    $tsql = "exec atualiza_saldos @empresa=?, @filial=?, @produto=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaNotaSaida($params){
    $tsql = "exec cria_notasaida @empresa=?, @filial=?, @produto=?, @serie=?, @vlmerc=?, @especie=?, @codigo=?, @fretecta=?, @vendedor=?, @promotor=?, @perccom=?, @perccoma=?, @transp=?, @vlicm=?, @vlipi=?, @vlfrete=?, @vlseguro=?, @vloutros=?, @vldesc=?, @vlpis=?, @vlcofins=?, @prazo=?, @usuario=?, @transporte=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);      
}

function spBaixaPagamentos($params){
    $tsql = "exec baixa_pagamentos @empresa=?, @filial=?, @codigo=?, @nota=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaItemNotaSaida($params){
    $tsql = "exec cria_item_notasaida @empresa=?, @filial=?, @produto=?, @nota=?, @item=?, @especie=?, @pedido=?, @itempedido=?, @natureza=?, @percicm=?, @percipi=?, @qtfat=?, @pefat=?, @vlunitario=?, @vlmerc=?, @vlicm=?, @vlipi=?, @vlpis=?, @vlcofins=?, @vlbaseicm=?, @vlbaseipi=?, @vlrateio=?, @vlmedio=?, @unidade=?, @tr=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaAtendidos($params){
    $tsql = "exec cria_atendidos @empresa=?, @filial=?, @nota=?, @item=?, @codigo=?, @especie=?, @pefat=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaProgramacao($params){
    $tsql = "exec baixa_programacao @empresa=?, @filial=?, @nota=?, @item=?, @venda=?, @itemvenda=?, @pefat=?, @volume=?, @ordem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaVendasC($params){
    $tsql = "exec baixa_vendasc @empresa=?, @filial=?, @venda=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaVendasI($params){
    $tsql = "exec baixa_vendasi @empresa=?, @filial=?, @venda=?, @item=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/**
* Fim Cadastro de Notas
*/

function spRecusaCotacaoVenda($params){
    $tsql = "exec recusa_cotacaovendas @empresa=?, @filial=?, @codigo=?, @cotacao=?, @versao=?, @motivo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spReabreOrdemCompra($params){
    $tsql = "exec reabre_ordemcompra @empresa=?, @filial=?, @numcotacao=?, @versao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/**
 * Entrada de Notas
*/
function spCriaNotaEntra($params){
    $tsql = "exec cria_notaentra @empresa=?, @filial=?, @nota=?, @codigo=?, @sitnf=?, @dtnota=?, @perccom=?, @perccoma=?, @transp=?, @vltotaln=?, @vlmerc=?, @vlicm=?, @vlipi=?, @vlfrete=?, @vlseguro=?, @vloutros=?, @vldesc=?, @vltpis=?, @vltcofins=?, @prazo=?, @usuario=?, @especie=?, @situacao=?, @serie=?, @idnfe=?, @ordcomp=?, @vlrtotimp=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaNotaEntraItem($params){
    $tsql = "exec cria_notaentraitem @empresa=?, @filial=?, @produto=?, @volume=?, @ordem=?, @nota=?, @item=?, @dtmov=?, @pedido=?, @itempedido=?, @natureza=?, @percicm=?, @percicms=?, @percipi=?, @percredu=?, @percm1=?, @percm2=?, @percm3=?, @qtfat=?, @pefat=?, @vlunitario=?, @qtsaldo=?, @qtsaldo2=?, @vlmerc=?, @vldesc=?, @vlicm=?, @vlipi=?, @vlmpis=?, @vlmcofins=?, @vlbaseicm=?, @vlbaseipi=?, @vlrateio=?, @vlmedio=?, @vlbasevenda=?, @especie=?, @unidade=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaItemOrdComp($params){
    $tsql = "exec baixa_itemordcomp @empresa=?, @filial=?, @numped=?, @numoc=?, @item=?, @qtdprod=?, @nota=?, @dtentrega=?, @versao=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spBaixaOrdComp($params){
    $tsql = "exec baixa_ordcomp @empresa=?, @filial=?, @numped=?, @numoc=?, @versao=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaVolumes($params){
    $tsql = "exec cria_volumes @empresa=?, @filial=?, @produto=?, @boobs=?, @qtpro=?, @qtaloca=?, @qtcor=?, @qtsaldo=?, @operador=?, @impre=?, @serie=?, @compra=?, @itemcompra=?";
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

function spCriaAnalizado($params){
    $tsql = "exec cria_analizado @empresa=?, @filial=?, @volume=?, @nota=?, @item=?, @especie=?, @serie=?, @codfor=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/**
 * MAQUINAS
*/
function spCriaMaquinaAco($params) {
    $tsql = "exec cria_maquinas_aco @empresa=?, @filial=?, @descricao=?, @qtdia=?, @fabricante=?, @capacidade=?, @local=?, @dtproxi=?, @dtmanu=?, 
    @observamanu=?, @motoriza=?, @dtajuste=?, @dtvalida=?, @norma=?, @grupo=?, @grupo2=?, @grumaqui=?, @familia1=?, @familia2=?, @situacao=?, @leadtime=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $row['resultado'] = 'sucesso';
        return $row;

    }else {
        $errors = sqlsrv_errors();
        return $errors;
        // return false;
    }
    sqlsrv_free_stmt($stmt);  
}

function spCriaDetalheFerramenta($params) {
    $tsql = "exec cria_detalheferram @empresa=?, @filial=?, @maquina=?, @diametrofaca=?, @toleranciacorte=?, @diamintexpulsador=?, @diametrocalcosep=?, 
    @diametrodiscosep=?, @corte=?, @acionamento=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDetalheMateriaPrima($params) {
    $tsql = "exec cria_detalhematp @empresa=?, @filial=?, @maquina=?, @larguracorte=?, @espessuraSAEmin=?, @espessuraSAEmax=?, @espessuraestruturalmin=?,
    @espessuraestruturalmax=?, @larguramin=?, @larguramax=?, @larguramaxestrut=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDetalheMaqui($params) {
    $tsql = "exec cria_detalhemaqui @empresa=?, @filial=?, @maquina=?, @capacidademax=?, @capacidademaxfrente=?, @capacidademaxtras=?, @diamintrebobmin=?,
    @diamintrebobmax=?, @diamextrebob=?, @diamentradesbob=?, @diamextdesbob=?, @diamintdesbobmin=?, @diamintdesbobmax=?, @comprimentoeixo=?, @comprimentoentrada=?, 
    @capacidadecorte=?, @toleranciacorte=?, @guiaentramin=?, @guiaentramax=?, @larguracortemin=?, @larguracortemax=?, @acionamento=?, @regulagem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaImagemMaq($params) {
    $tsql = "exec cria_imagemmaq @empresa=?, @filial=?, @maquina=?, @item=?, @imagem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


function spCriaFolgaFacas($params) {
    $tsql = "exec cria_folgafacas @empresa=?, @filial=?, @maquina=?, @medidamin=?, @medidamax=?, @folga=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

/**
 * Desativa Ficha Tecnica
*/
function spDesativaFichaTec($params) {
    $tsql = "exec desativa_fichatec @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Cancela Nota Fiscal
function spCancelaNotaSaida($params) {
    $tsql = "exec cancela_notasaida @empresa=?, @filial=?, @nota=?, @codigo=?, @serie=?, @especie=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCancelaNotaEntrada($params) {
    $tsql = "exec cancela_notaentrada @empresa=?, @filial=?, @nota=?, @codigo=?, @serie=?, @especie=?, @usuario=?, @tipo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

//OPERADOR MAQUINA
function spCriaOperadorMaquina($params) {
    $tsql = "exec cria_operador_maquina @empresa=?, @filial=?, @operador=?, @nome=?, @maquina=?, @depto=?, @funcao=?, @data=?, @imagem=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

//HOMOLOGACAO
function spCriaHomologados($params) {
    $tsql = "exec cria_homologados @empresa=?, @filial=?, @codfor=?, @sequencia=?, @cgcfil=?, @avcb=?, @dtavcb=?, @inscricao=?, @dtinscricao=?, @alvara=?, @iso=?, 
    @dtiso=?, @iatf=?, @dtiatf=?, @apto=?, @dtapto=?, @descapto=?, @ativo=?, @dtativo=?, @descativo=?, @dtcgc=?, @usuario=?, @dtlog=?, @observa=?, @opcao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaProdHomologados($params) {
    $tsql = "exec cria_prod_homologados @empresa=?, @filial=?, @codfor=?, @produto=?, @ativo=?, @dtativo=?, @tipo=?, @usuario=?, @opcao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

//Cancelar Ordem de Produção
function spCancelarOrdemProducao($params) {
    $tsql = "exec cancela_programacao @empresa=?, @filial=?, @numero=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spExtornaVendasI($params) {
    $tsql = "exec extorna_vendasi @empresa=?, @filial=?, @venda=?, @item=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spExtornaVolume($params) {
    $tsql = "exec extorna_volume @empresa=?, @filial=?, @volume=?, @ordem=?, @pefat=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

//Cria Embalagem
function spCriaEmbalagem($params) {
    $tsql = "exec cria_embalagens @empresa=?, @filial=?, @codint=?, @codemb=?, @peso=?, @capacidade=?, @unidade=?, @codfor=?, @opcao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

//Inicia/Pausa Ordem Produção
function spIniciaOrdemProd($params) {
    $tsql = "exec inicia_ordemprod @empresa=?, @filial=?, @nrop=?, @sequencia=?, @maquina=?, @codop=?, @voluori=?, @ordemori=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spIncluiParadaOp($params) {
    $tsql = "exec inclui_parada_op @empresa=?, @filial=?, @numero=?, @item=?, @maquina=?, @parada=?, @observacao=?, @usuario=?, @situacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Cotacao Doc
function spCriaDocCotacaoVenda($params) {
    $tsql = "exec cria_doccotacaovenda @empresa=?, @filial=?, @cotacao=?, @localizacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Venda Doc
function spCriaDocVenda($params) {
    $tsql = "exec cria_docvenda @empresa=?, @filial=?, @venda=?, @localizacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Cotacao Compra Doc
function spCriaDocCotacaoCompra($params) {
    $tsql = "exec cria_doccotacaocompra @empresa=?, @filial=?, @cotacao=?, @localizacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Medidas Lote
function spIncluiMedidasLote($params) {
    $tsql = "exec inclui_medidas_lote @empresa=?, @filial=?, @volume=?, @ordem=?, @venda=?, @item=?, @med1=?, @med2=?, @med3=?, @alocacao=?, @peso=?, @altfardo=?, @diamint=?, @diamext=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Transportador
function spCriaTransportador($params) {
    $tsql = "exec cria_transportador @empresa=?, @filial=?, @codigo=?, @viatransp=?, @descricao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Ficha Tecnica Doc
function spCriaDocFichaTecnica($params) {
    $tsql = "exec cria_docfichatecnica @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @localizacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaObsFichaTec($params) {
    $tsql = "exec cria_obsfichatec @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @observacao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Conciliacao Bancaria
function spEncerraConciliacao($params) {
    $tsql = "exec encerra_conciliacao @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?, @saldo=?, @dtsaldo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spSolicitaLiberacaoBanco($params) {
    $tsql = "exec solicita_liberacao_banco @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?, @dtsaldo=?, @usuariode=?, @usuariopara=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spLiberaBanco($params) {
    $tsql = "exec libera_banco @empresa=?, @filial=?, @banco=?, @agencia=?, @conta=?, @dtsaldo=?, @usuario=?, @liberacao=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Recusar Ficha Tecnica
function spRecusaFichaBloqueada($params) {
    $tsql = "exec recusa_ficha_bloqueada @empresa=?, @filial=?, @codigo=?, @produto=?, @refere=?, @versao=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// Parametros dos Documentos
function spCriaCampoTipoDoc($params) {
    $tsql = "exec cria_campotipodoc @empresa=?, @filial=?, @tipo=?, @campo=?, @descricao=?, @tipocampo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaTipoDoc($params) {
    $tsql = "exec cria_tipodoc @tipo=?, @descricao=?, @obrigatorio=?, @validade=?, @revisao=?, @modulo=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDocClifor($params) {
    $tsql = "exec cria_doc_clifor @empresa=?, @filial=?, @codigo=?, @tipo=?, @numero=?, @dtemissao=?, @validade=?, @revisao=?, @arquivo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

// ORDEM DE PRODUCAO
function spCriaPlanoCorte($params) {
    $tsql = "exec cria_planocorte @empresa=?, @filial=?, @venda=?, @item=?, @volume=?, @ordem=?, @grupo=?, @familia=?, @largurabob=?, @med1=?, @pesobobina=?,
    @tirada=?, @diambob=?, @diametro2=?, @massa=?, @voltas=?, @totalcortado=?, @refilo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaItemPlanoCorte($params) {
    $tsql = "exec cria_item_planocorte @empresa=?, @filial=?, @numero=?, @sequencia=?, @cortes=?, @largura=?, @larguratotal=?, @peso=?, @programado=?, @qtderolos=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaPlanoCorteChapa($params) {
    $tsql = "exec cria_planocorte_chapa @empresa=?, @filial=?, @venda=?, @item=?, @numero=?, @volume=?, @ordem=?, @grupo=?, @familia=?, @largura=?, @espessura=?, @comprimento=?,
    @pesoproduzir=?, @pesomaximo=?, @pesopeca=?, @qtdeporfardos=?, @qtdefardos=?, @pesofardo=?, @usuario=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaDesignados($params) {
    $tsql = "exec cria_designado @empresa=?, @filial=?, @codigo=?, @produto=?, @volume=?, @ordem=?, @venda=?, @item=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spCriaOrdemProducao($params) {
    $tsql = "exec cria_ordem_producao @empresa=?, @filial=?, @maquina=?, @maquina1=?, @volume=?, @ordem=?, @venda=?, @item=?, @pacotes=?, @observacao=?, @usuario=?, 
    @codigo=?, @qtde=?, @produto=?, @grupo=?, @grupomp=?, @numero=?";
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

function spGeraPacotes($params) {
    $tsql = "exec gera_pacotes @empresa=?, @filial=?, @alocacao=?, @venda=?, @item=?, @volume=?, @produto=?, @pacotes=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spAprovaPlanoCorte($params) {
    $tsql = "exec aprova_planocorte @empresa=?, @filial=?, @volume=?, @ordem=?, @usuario=?, @numero=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}

function spLancaApontamento($params) {
    $tsql = "exec lanca_apontamento @empresa=?, @filial=?, @sequencia=?, @numero=?, @item=?, @volume=?, @instrumento=?, @espessura=?, @largura=?, @comprimento=?, @empeno=?,
    @esquadro=?, @diamint=?, @diamest=?, @aspecto=?, @operador=?, @maquina=?";
    $stmt = sqlsrv_query($GLOBALS['conn'], $tsql,$params);

    if ($stmt) {
        return "sucesso";
    }else {
        $errors = sqlsrv_errors();
        return $errors;
    }
    sqlsrv_free_stmt($stmt);
}


?>