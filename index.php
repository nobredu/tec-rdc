<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/php/restrito.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sidebar.php';

$emp = $_SESSION['empresa'];
$filial = $_SESSION['filial'];

$origens = spConsultaOrigem(['']);

$tipos = spConsultaTipoProduto(['']);

$grupos = spConsultaGrupos([$emp, $filial, '']);

$familias = spConsultaFamilias([$emp, $filial, '']);

$quali = spConsultaQualidades([$emp, $filial, '']);

$unidades = spConsultaUnidades(['']);

$ccf = spConsultaClassificacaoFiscais(['']);

// echo "<pre>";
// print_r($unidades);
// echo "<pre>";

// PEGANDO ERRO OU SUCESSO

if(isset($_SESSION["mensagem"])):
    $msg = $_SESSION["mensagem"];
    if($msg['type'] == 'error'){
        echo "<script type='text/javascript'>toastr.error('".$msg['msg']."','".$msg['title']."',{ timeOut: 6000});</script>";
    }else{
        echo "<script type='text/javascript'>toastr.success('".$msg['msg']."','".$msg['title']."',{ timeOut: 5000});</script>";
    }
    unset($_SESSION["mensagem"]);
endif;
?>

<!--corpo main-->

<body>

    <!-- IMPORTS -->
    <script type="text/javascript" src="produto.js?v=76"></script>
    <!-- FIM IMPORTS -->

    <section class="programa">
        <section class="progHeader">
            <!-- <span class="progHeader__titulo">Cadastro de Produtos</span> -->
        </section>
        <section class="progForm">
            <span class="progForm__titulo">Cadastro de Produtos</span>


            <div class="formulario">
                <form action="cria_produto.php" method="POST" class="frm-formulario cadastra" name="novoProduto" id="formulario">

                    <div class="formulario__flex">

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Código Int:</label>
                            <input type="text" class="formulario__input formulario__input--disabled uppercase campo--15 campos" value="" name="cod_int" id="cod_int" readonly>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Código Ext:</label>
                            <input type="text" class="formulario__input formulario__input--disabled uppercase campo--15 campos" value="" name="cod_ext" id="cod_ext" readonly>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Cód. Fabrica:</label>
                            <input type="text" class="formulario__input formulario__input--disabled uppercase campo--15 campos" value="" name="cod_fabrica" readonly>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                        </div>

                    </div>



                    <div class="formulario__container">
                        <label class="formulario__label fixo--15">Descrição:</label>
                        <input type="text" class="formulario__input uppercase campo--80 campos" value="" name="descricao" required>

                        <div class="tooltip">
                            <img src="/img/icons/help-icon-blue.png" alt="">
                            <span class="tooltiptext">
                                Texto de exemplo </span>
                        </div>
                    </div>



                    <div class="formulario__container">
                        <label class="formulario__label fixo--15">Gera Lote:</label>
                        <div class="checkbox-container">
                            <label class="checkbox-label">
                                <input type="checkbox" class="campos" value="S" name="gera_lote" id="gera_lote" />
                                <span class="checkbox-custom rectangular"></span>
                            </label>
                        </div>

                        <div class="tooltip">
                            <img src="/img/icons/help-icon-blue.png" alt="">
                            <span class="tooltiptext">
                                Texto de exemplo </span>
                        </div>

                        <label class="input--2"></label>

                    </div>



                    <div class="formulario__flex">

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Origem:</label>
                            <select class="input--select2 fixo--30 campos" name="origem" required>
                                <option value="" selected disabled>Selecione uma Origem</option>

                                <?php
                                foreach($origens as $arr){

                                    echo '<option value="'. $arr['origem'] .'">'. $arr['origem'] . ' - ' . $arr['descricao'] .'</option>';

                                }
                                ?>

                            </select>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Tipo:</label>
                            <select class="input--select2 campo--30 campos" name="tipo" required>
                                <option value="" selected disabled>Selecione um Tipo</option>

                                <?php
                                foreach($tipos as $arr){

                                    echo '<option value="'. $arr['tipoprod'] .'">'. $arr['tipoprod'] . ' - ' . $arr['descricao'] .'</option>';

                                }
                                ?>

                            </select>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                        </div>

                    </div>



                    <div class="formulario__flex">

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Grupo:</label>
                            <select class="input--select2 fixo--30 campos" name="grupo" id="grupo" onchange="lote()" required>
                                <option value="" selected disabled>Selecione um Grupo</option>

                                <?php
                                foreach($grupos as $arr){

                                    echo '<option value="'. $arr['grupo'] .'">'. $arr['grupo'] . ' - ' . $arr['descricao'] .'</option>';

                                }
                                ?>

                            </select>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Família:</label>
                            <select class="input--select2 campo--30 campos" name="familia" required>
                                <option value="" selected disabled>Selecione uma Familia</option>

                                <?php
                                foreach($familias as $arr){

                                    echo '<option value="'. $arr['familia'] .'">'. $arr['familia'] . ' - ' . $arr['descricao'] .'</option>';

                                }
                                ?>

                            </select>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                        </div>

                    </div>


                    <div class="formulario__flex">

                        <div class="formulario__container">
                            <label class="formulario__label fixo--15">Produto:</label>
                        </div>

                        <div class="formulario__container">

                            <input type="number" min="0" step="0.001" value="0" class="formulario__input campo--13 campos" name="med1">
                            <label class="formulario__icone_center campo--5">X</label>
                            <input type="number" min="0" step="0.001" value="0" class="formulario__input campo--13 campos" name="med2">
                            <label class="formulario__icone_center campo--5">X</label>
                            <input type="number" min="0" step="0.001" value="0" class="formulario__input campo--13 campos" name="med3">

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                        </div>

                    </div>

                    <div class="formulario__flex">

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Qualidade:</label>
                            <select class="input--select2 campo--30 campos" name="qualidade">
                                <option value="" selected disabled>Selecione a qualidade</option>

                                <?php
                                foreach($quali as $arr){

                                    echo '<option value="'. $arr['codigo'] .'">'. $arr['codigo'] . ' - ' . $arr['descricao'] .'</option>';

                                }
                                ?>

                            </select>
                            <!-- <input type="text" class="formulario__input input--10" name="qualidade" required> -->

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--20">Unidade de Medida:</label>
                            <select class="input--select2 campo--30 campos" name="unidade_de_medida" id="unidade" required>
                                <option value="" selected disabled>Selecione a Unidade</option>

                                <?php
                                foreach($unidades as $arr){

                                    echo '<option value="'. $arr['unidade'] .'">'. $arr['unidade'] . ' - ' . $arr['undesc'] .'</option>';

                                }
                                ?>

                            </select>

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>

                            <label class="input--2"></label>

                        </div>

                        <div class="formulario__container">

                            <label class="formulario__label fixo--15">Peso Unitário:</label>
                            <input type="number"  min="0" step="0.001" class="formulario__input campo--15 campos" name="peso_unitario" value="" id="peso_unitario">

                            <div class="tooltip">
                                <img src="/img/icons/help-icon-blue.png" alt="">
                                <span class="tooltiptext">
                                    Texto de exemplo </span>
                            </div>
                            
                        </div>

                    </div>


                    <div class="formulario__container">
                        <label class="formulario__label fixo--15">Cód. Fiscal:</label>
                        <select class="input--select2 campo--30 campos" name="cod_fiscal" required>
                            <option value="" selected disabled>Selecione o Código</option>

                            <?php
                            foreach($ccf as $arr){

                                echo '<option value="'. $arr['codccf'] .'">'. $arr['codccf'] . ' - ' . $arr['ccfdesc'] .'</option>';

                            }
                            ?>

                        </select>

                        <div class="tooltip">
                            <img src="/img/icons/help-icon-blue.png" alt="">
                            <span class="tooltiptext">
                                Texto de exemplo </span>
                        </div>

                    </div>

                    <div class="formulario__btn">
                        <button type="submit">
                            <span>Cadastrar</span>
                        </button>
                        <button onclick="redireciona('./')" type="button">
                            <span>Limpar</span>
                        </button>
                        <button onclick="cancelar()" type="button">
                            <span>Cancelar</span>
                        </button>
                    </div>


                </form>
            </div>

        </section>
    </section>
</body>

</html>