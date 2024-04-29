<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/restrito.php';
// include $_SERVER['DOCUMENT_ROOT'] . '/sidebar.php';

// $emp = $_SESSION['empresa'];
// $filial = $_SESSION['filial'];

// $origens = spConsultaOrigem(['']);

// $tipos = spConsultaTipoProduto(['']);

// $grupos = spConsultaGrupos([$emp, $filial, '']);

// $familias = spConsultaFamilias([$emp, $filial, '']);

// $quali = spConsultaQualidades([$emp, $filial, '']);

// $unidades = spConsultaUnidades(['']);

// $ccf = spConsultaClassificacaoFiscais(['']);

// echo "<pre>";
// print_r($unidades);
// echo "<pre>";

// PEGANDO ERRO OU SUCESSO

// if(isset($_SESSION["mensagem"])):
//     $msg = $_SESSION["mensagem"];
//     if($msg['type'] == 'error'){
//         echo "<script type='text/javascript'>toastr.error('".$msg['msg']."','".$msg['title']."',{ timeOut: 6000});</script>";
//     }else{
//         echo "<script type='text/javascript'>toastr.success('".$msg['msg']."','".$msg['title']."',{ timeOut: 5000});</script>";
//     }
//     unset($_SESSION["mensagem"]);
// endif;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Responsivo</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="produto.js?v=76"></script>
</head>
<body>
    <header>
        <img src="img/logo_nova.png" alt="Logo do Sistema">
        <h1>Sistema de Gerenciamento de EHS</h1>
    </header>
    <form action="cria_produto.php" method="POST" name="novoProduto" id="formulario">
        <h2 class="titulo-form">CADASTRO DE PRODUTOS</h2>
        <div class="formulario">
            <div class="formulario__row">
                <label class="formulario__label"><strong>Código Int:</strong></label>
                <input type="text" value="" name="cod_int" id="cod_int" disabled class="formulario__field">
                <i><img src="img/icons/help-icon-blue.png"></i>

                <label class="formulario__label"><strong>Código Ext:</strong></label>
                <input type="text" value="" name="cod_ext" id="cod_ext" disabled class="formulario__field">
                <i><img src="img/icons/help-icon-blue.png"></i>

                <label class="formulario__label"><strong>Cód Fabrica:</strong></label>
                <input type="text" value="" name="cod_fabrica" id="cod_fabrica" disabled class="formulario__field">
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__row">            
                <label class="formulario__label"><strong>Descrição:</strong></label>
                <input value="" name="descricao" type="text" class="formulario__field" required>
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__row">                
                <label class="formulario__label"><strong>Gera Lote:</strong></label>
                <input type="checkbox" class="formulario__checkbox" value="S" name="gera_lote" id="gera_lote">
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__row">                
                <label class="formulario__label"><strong>Origem:</strong></label>
                <select class="formulario__field" name="origem" required>
                    <option value="" selected>Selecione uma Origem</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($origens as $arr){

                        echo '<option value="'. $arr['origem'] .'">'. $arr['origem'] . ' - ' . $arr['descricao'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i><br>

                
                <label class="formulario__label"><strong>Tipo:</strong></label>
                <select class="formulario__field" name="tipo" required>
                    <option value="">Selecione uma Origem</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($tipos as $arr){

                        echo '<option value="'. $arr['tipoprod'] .'">'. $arr['tipoprod'] . ' - ' . $arr['descricao'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i><br>
            </div>

            <div class="formulario__row">
                
                <label class="formulario__label"><strong>Grupo:</strong></label>
                <select class="formulario__field" name="grupo" id="grupo" onchange="lote()" required>
                    <option value="">Selecione uma Origem</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($grupos as $arr){

                        echo '<option value="'. $arr['grupo'] .'">'. $arr['grupo'] . ' - ' . $arr['descricao'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i><br>

                
                <label class="formulario__label"><strong>Familia:</strong></label>
                <select class="formulario__field" name="familia" required>
                    <option value="">Selecione uma Origem</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($familias as $arr){

                        echo '<option value="'. $arr['familia'] .'">'. $arr['familia'] . ' - ' . $arr['descricao'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i><br>
            </div>

            <div class="formulario__row">
                
                <label class="formulario__label"><strong>Produto:</strong></label>
                <input class="formulario__field" type="number" min="0" step="0.001" value="0" name="med1">

            
                <label class="formulario__label"><strong> X </strong></label>
                <input class="formulario__field" type="number" min="0" step="0.001" value="0" name="med2">

                
                <label class="formulario__label"><strong> X </strong></label>
                <input class="formulario__field" type="number" min="0" step="0.001" value="0" name="med3">
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__row">
                
                <label class="formulario__label"><strong>Qualidade:</strong></label>
                <select class="formulario__field" name="qualidade">
                    <option selected value="">Selecione a qualidade</option>
                    <option value="1">teste</option>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i>

            
                <label class="formulario__label"><strong>Unidade Medida:</strong></label>
                <select class="formulario__field" name="unidade_de_medida" id="unidade" required>
                    <option selected value="">Selecione a Unidade</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($unidades as $arr){

                        echo '<option value="'. $arr['unidade'] .'">'. $arr['unidade'] . ' - ' . $arr['undesc'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i>

            
                <label class="formulario__label"><strong>Peso Unitario:</strong></label>
                <input type="number"  min="0" step="0.001" class="formulario__field" name="peso_unitario" value="" id="peso_unitario">
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__row">
                
                <label class="formulario__label"><strong>Cód. Fiscal:</strong></label>
                <select class="formulario__field" name="cod_fiscal" required>
                    <option selected value="">Selecione o Código</option>
                    <option value="1">teste</option>
                    <?php
                    foreach($ccf as $arr){

                        echo '<option value="'. $arr['codccf'] .'">'. $arr['codccf'] . ' - ' . $arr['ccfdesc'] .'</option>';

                    }
                    ?>
                </select>
                <i><img src="img/icons/help-icon-blue.png"></i>
            </div>

            <div class="formulario__btn">
                <button id="submit" type="submit">
                    <span>Cadastrar</span>
                </button>
                <button onclick="redireciona('./')" type="button">
                    <span>Limpar</span>
                </button>
                <button onclick="cancelar()" type="button">
                    <span>Cancelar</span>
                </button>
            </div>
        </div>
    </form>
</body>
</html>
