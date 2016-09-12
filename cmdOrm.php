<?php 
if (!isset($_SESSION)) session_start();

if (isset($_GET['pop'])) {
	formCadOrmStart();
}
function sys_cmdOrm ($acao) {
	switch ($acao)
	{
		case 'formCadOrm':
		//Form inicial
			formCadOrm ();
		break;
		case 'formCadOrmPop':
		//Form para popular
			formCadOrmPop ();
		break;
		case 'formCadOrmStart':
		//CallBack Dados
			formCadOrmStart ();
		break;
	}
}

function formCadOrm (){
	//	Mostra inputs
?>	
<script>

//CreatObject
function createRequest () {
	try{
		 request = new XMLHttpRequest();
	}catch (tryMS){
		try{
			 request = new ActiveXObject("Microsoft.XMLHTTP");
		}catch (otherMS){
			try {
			 request = new ActiveXObject("Msxm12.XMLHTTP");
			}catch (failed){
			 request = null;}
		}
	}
	return request;
}
//Chama form para popular
function  acaoOrmPop(acao){request = createRequest();if(request==null){alert("Não criado solicitar");return;	}
	
	var url_bd = document.getElementById('url_bd').value;
	var name_bd = document.getElementById('name_bd').value;
	var input_qtd = document.getElementById('input_qtd').value;
	var url= 'acao.php?acaoOrm='+acao+'&url_bd='+url_bd+'&name_bd='+name_bd+'&input_qtd='+input_qtd;
	request.open("POST",url,true);
	request.onreadystatechange = rAcaoOrmPop;
	request.send();
	
}

function rAcaoOrmPop(){
	if(request.readyState == 4){
		if (request.status == 200){
			content = document.getElementById("display_orm");
			content.innerHTML = request.responseText;
			
		}
	}
}

</script>
	<div class="row">
		<div class="col-md-12">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">CMD ORM</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="acao.php?acaoOrm=" method="post">
						<fieldset>
							<!-- Text area-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="txtDeta">Caminho BD</label>
							  <div class="col-md-6">                     
								<input class="form-control" id="url_bd" name="url_bd"></input>
							  </div>
							</div>
							<!-- Text area-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="txtDeta">Nome BD</label>
							  <div class="col-md-6">                     
								<input class="form-control" id="name_bd" name="name_bd"></input>
							  </div>
							</div>
							<!-- Text area-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="txtDeta">Qtd Inputs</label>
							  <div class="col-md-6">                     
								<input class="form-control" id="input_qtd" name="input_qtd"></input>
							  </div>
							</div>
							<div class="col-md-offset-6"><img src="img/validar.png" alt="..." onclick="acaoOrmPop('formCadOrmPop')"><p><b>Incluso:</b> "regCad", Dtcria, Dtalt, Token;</p></div>
							
						</fieldset>
					</form>
						<form class="form-horizontal" role="form" action="cmdOrm.php?pop=1" method="post">
							<fieldset>
								<div class="col-md-6" id="display_orm"></div>
							</fieldset>
						</form>
								<div class="col-md-6" id="display_orm_pop"></div>
				</div>
			</div>
		</div>
	</div>
<?php
}

function formCadOrmPop (){
	
	$url_bd = $_REQUEST['url_bd']; //pega caminho do banco
	$tabela = $_REQUEST['name_bd']; //pega nome do banco
	$input_qtd = $_REQUEST['input_qtd']; //pega qtd inputs tables
	
	$_SESSION['input_qtd'] = $_REQUEST['input_qtd']; // pega qtd de varredura 
	$_SESSION['name_bd'] = $_REQUEST['name_bd']; // pega name de varredura 
	
	//	Mostra inputs
?>	
	<fieldset>
		<?php
		for ($i = 1; $i <= $input_qtd; $i++) {
		//Realiza duplicidade do contador
		?>
			<!-- Text area-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="txtDeta">Input Pop <?php echo $i; ?></label>
			  <div class="col-md-6">                     
				<input class="form-control" id="inputPop_<?php echo $i; ?>" name="inputPop_<?php echo $i; ?>"></input>
			  </div>
			</div>
		<?php
		}
		?>
		<div class="form-group">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
				<button id="button1id" class="btn btn-sm btn-info" >Cadastrar</button>
			  </div>
		</div>
		<!--<img src="img/validar.png" alt="..." onclick="acaoOrm('formCadOrmPopCod')">-->
	</fieldset>

<?php
}

function formCadOrmStart (){
	
	/*foreach($_POST as $nome_campo => $valor){ 
	   $comando = "\$" . $nome_campo . "='" . $valor . "';"; 
	   eval($comando); 
	   echo $comando;
	} */
	$cont_0 = 0;
	$cont_1 = 0;
	$cont_2 = 0;
	$cont_3 = 0;
	$cont_4 = 0;
	$cont_5 = 0;
	
	$grava_txtDtCria  = "txtDtCria";
	$grava_txtDtAlt = "txtDtAlt";
	$grava_token = "token";
	$grava_ = "\$grava_";
	
	//Mostra codigo mysql criação tabela------------
	$tabela = "tb_".$_SESSION['name_bd'];
	
	echo "CREATE TABLE IF NOT EXISTS ". $tabela ." ("; ?></br><?php //mostra create tabela
	
	foreach($_POST as $nome_campo => $valor){ // pega informação formulário
		$comando = "\$" . $valor . ";"; 
		$post = "\$_POST"; 
		$grava = "\$grava_"; 
	   //incrementa 1 blc if
		if($cont_0 == 0){
		//Define Cabeçalho -----
			$cont_0 = 1;
			echo "id INT(255) AUTO_INCREMENT PRIMARY KEY";?></br><?php
			echo ",". $grava_txtDtCria . " VARCHAR(255)"; ?></br><?php
			echo ",". $grava_txtDtAlt . " VARCHAR(255)"; ?></br><?php
			echo ",". $grava_token  . " VARCHAR(255)";?></br><?php
		}
			
		echo ",". $valor . " VARCHAR(255)"; ?></br><?php

	}

	echo ")"; ?></br>//-----</br><?php //Fecha tabela
	//Fecha codigo mysql criação tabela------------
	
	foreach($_POST as $nome_campo => $valor){ 
		$comando = "\$" . $valor . ";"; 
		$post = "\$_POST"; 
		$grava = "\$grava_"; 
	   //incrementa 1 blc for
		if($cont_1 == 0){
		//Define Cabeçalho -----
			$cont_1 = 1;
			$comando1 = "include_once '/data/conexao.php';";
			$comando2 = "if(!empty(" . $post . "['".$valor."'])){";
			echo "function regCad".$_SESSION['name_bd']." () { "; ?></br><?php //Abre função de registro
			echo "header('Content-Type: text/html; charset=iso-8859-1',true);";?></br><?php
			echo $comando1; ?></br><?php
			echo $comando2; ?></br><?php
			echo "try{"; ?></br><?php
			
		}
		if($cont_2 == 0){
		//Define data -----
			$cont_2 = 1;
			echo $grava_.$grava_txtDtCria . " = date('Y-m-d | h:i:sa');"; ?></br><?php
			//echo $grava_.$grava_txtDtAlt . " = strip_tags(trim(" . $post . "['dtAlt']));";?></br><?php
			echo $grava_.$grava_txtDtAlt . "='';";?></br><?php
			echo  $grava_.$grava_token."='';"; ?></br><?php
		}
		echo $grava . $valor . " = strip_tags(trim(" . $post . "['" . $valor . "']));";?></br><?php
		eval($comando); 
		//echo $comando; 
	}//---FIM FOREACH
		if($cont_3 == 0){
			$cont_3 = 1;
			$sql = "\$sql";
			$tabela = "tb_".$_SESSION['name_bd'];
		//Prepara insert into
			echo  $sql. " = ' INSERT INTO " . $tabela . " ("; 
			
		}
		//Inclui data insert
		echo $grava_txtDtCria.",".$grava_txtDtAlt.",".$grava_token;
		foreach($_POST as $nome_campo => $valor){
		//Mostra Tabelas do banco
		   echo "," . $valor;
		}
		echo ")';";
		//---Inicia VALUES
		$tabela = "";?></br><?php
		echo  $sql. ".= ' VALUES" . $tabela . "("; 
		//inclui data value
		echo ":grava_".$grava_txtDtCria.",:grava_".$grava_txtDtAlt.",:grava_".$grava_token;
		foreach($_POST as $nome_campo => $valor){
		//Mostra inclui values
			if($cont_4 == 0){
			//Define data -----
				$cont_4 = 1;
				echo ",:grava_" . $valor;
			}else{
				echo ",:grava_" . $valor;
			}
		}
		echo ")';"; ?></br><?php
		//Fecha values	
		//Inicia prepare
		$sql = "\$sql";
		$incluir = "\$incluir ";
		$conecta = "\$conecta ";
		
		echo $incluir ."=". $conecta . "->prepare(". $sql. ");";?></br><?php
		foreach($_POST as $nome_campo => $valor){
		   $comando = "\$" . $valor . "='" . 0 . "';"; 
		   //incrementa 1 blc for
		   // Popular array.
			if($cont_5 == 0){
			//Define data -----
				$cont_5 = 1;
				echo $incluir . "->bindValue(':grava_" . $grava_txtDtCria . "',$grava_" . $grava_txtDtCria . ",PDO::PARAM_STR); "; ?></br><?php
				echo $incluir . "->bindValue(':grava_" . $grava_txtDtAlt . "',$grava_" . $grava_txtDtAlt . ",PDO::PARAM_STR); "; ?></br><?php
				echo $incluir . "->bindValue(':grava_" . $grava_token . "',$grava_" . $grava_token . ",PDO::PARAM_STR); "; ?></br><?php
			}
			echo $incluir . "->bindValue(':grava_" . $valor . "',$grava_" . $valor . ",PDO::PARAM_STR); "; ?></br><?php
		}
		//Fecha prepare
		// Inicia incluir
		$incluir = "\$incluir";
		$error = "\$error";
		$href = '<a href="http://localhost/record/index.php">Voltar<a>';
		
		echo $incluir . "->execute();";?></br><?php
		echo "}";?></br><?php
		echo "catch(PDOException" . $error ."){ echo" . $error . "->getMessage(); }";?></br><?php
		echo "header('Location:../record/index.php?msg=Salvo com Sucesso');";?></br><?php //
		echo "}else{";?></br><?php
		echo "<a href=''>echo 'Campo Vázio --> Voltar<a>'; }";?></br><?php
		echo "}";?></br><?php// Fecha 
		echo "}";?></br><?php// Fecha Validador condicional se vazio
		echo " Correção para acentuação no bd = x = utf8_decode(x);";?></br><?php// Fecha Validador condicional se vazio

//------------FECHA RegCmdOrm
//------------INICIA AltCmdOrm
	$grava_txtDtCria  = "txtDtCria";
	$grava_txtDtAlt = "txtDtAlt";
	$grava_token = "token";
	$grava_ = "\$grava_";
	
	
	//Mostra codigo mysql criação tabela------------
	$tabela = "tb_".$_SESSION['name_bd'];
	
	echo ")"; ?>//-----</br><?php //Fecha tabela
	?></br><?php
	$cont_0 = 0;
	$cont_1 = 0;
	$cont_2 = 0;
	$cont_3 = 0;
	$cont_4 = 0;
	$cont_5 = 0;
	
	//Fecha codigo mysql criação tabela------------
	foreach($_POST as $nome_campo => $valor){ 
		$comando = "\$" . $valor . ";"; 
		$post = "\$_POST"; 
		$get = "\$_GET"; 
		$idr = "idr"; 
		$idr_var = "\$idr"; 
		$grava = "\$grava_"; 
		
	   //incrementa 1 blc for
		if($cont_1 == 0){
		//Define Cabeçalho -----
			echo '<div style="color: rgb(0, 3, 255);">';
			$cont_1 = 1;
			$comando1 = "include_once '/data/conexao.php';";
			$comando2 = "if(!empty(" . $get . "['".$idr."'])){";
			echo "function altCad".$_SESSION['name_bd']." () { "; ?></br><?php //Abre função de alteração
			echo "header('Content-Type: text/html; charset=iso-8859-1',true);";?></br><?php //Implementa Charset
			echo $comando1; ?></br><?php 
			echo $comando2; ?></br><?php
			echo "try{"; 
			
		}
		if($cont_2 == 0){
		//Define data -----
			$cont_2 = 1;
			//echo $grava_.$grava_txtDtCria . " = date('Y-m-d | h:i:sa');";
			//echo $grava_.$grava_txtDtAlt . " = strip_tags(trim(" . $post . "['dtAlt']));";?></br><?php
			echo $idr_var . " = strip_tags(trim(" . $get . "['" . $idr . "']));";?></br><?php
			echo $grava_.$grava_txtDtAlt . " = date('Y-m-d | h:i:sa');"; ?></br><?php
			echo  $grava_.$grava_token."='';"; ?></br><?php
		}
		echo $grava . $valor . " = strip_tags(trim(" . $post . "['" . $valor . "']));";?></br><?php
		eval($comando); 
		//echo $comando; 
	}//---FIM FOREACH
		if($cont_3 == 0){
			$cont_3 = 1;
			$sql = "\$sql";
			$tabela = "tb_".$_SESSION['name_bd'];
		//Prepara UPDATE into
			echo  $sql. " = ' UPDATE " . $tabela . " SET "; //Imprime MYSQL
			
		}
		//Inclui data UPDATE
		echo $grava_txtDtAlt . "=:grava_" . $grava_txtDtAlt. ", ".$grava_token ." =:grava_" . $grava_token;
		foreach($_POST as $nome_campo => $valor){
		//Mostra Tabelas do banco
		   echo ", " . $valor . "=:grava_" . $valor;
		}
		echo " WHERE id = :id';";
		//---Inicia VALUES
		//$tabela = "";?></br><?php
		
		//Inicia prepare
		$sql = "\$sql";
		$incluir = "\$alterar ";
		$conecta = "\$conecta ";
		
		echo $incluir ."=". $conecta . "->prepare(". $sql. ");";?></br><?php
		foreach($_POST as $nome_campo => $valor){
		   $comando = "\$" . $valor . "='" . 0 . "';"; 
		   //incrementa 1 blc for
		   // Popular array.
			if($cont_5 == 0){
			//Define data -----
				$cont_5 = 1;
				echo $incluir . "->bindValue(':id',$" . $idr . ",PDO::PARAM_STR); "; ?></br><?php
				echo $incluir . "->bindValue(':grava_" . $grava_txtDtAlt . "',$grava_" . $grava_txtDtAlt . ",PDO::PARAM_STR); "; ?></br><?php
				echo $incluir . "->bindValue(':grava_" . $grava_token . "',$grava_" . $grava_token . ",PDO::PARAM_STR); "; ?></br><?php
			}
			echo $incluir . "->bindValue(':grava_" . $valor . "',$grava_" . $valor . ",PDO::PARAM_STR); "; ?></br><?php
		}
		//Fecha prepare
		// Inicia incluir
		$incluir = "\$alterar";
		$error = "\$error";
		$href = '<a href="http://localhost/record/index.php">Voltar<a>';
		
		echo $incluir . "->execute();";?></br><?php
		echo "}";?></br><?php
		echo "catch(PDOException" . $error ."){ echo" . $error . "->getMessage(); }";?></br><?php
		echo "header('Location:../record/index.php?msg=Salvo com Sucesso');";?></br><?php //
		echo "}else{";?></br><?php
		echo "<a href=''>echo 'Campo Vázio --> Voltar<a>'; }";?></br><?php
		echo "}";?></br><?php// Fecha 
		echo "}";?></br></br><?php// Fecha Validador condicional se vazio
		echo " Correção para acentuação no bd = x = utf8_decode(x);";?></br><?php// Fecha Validador condicional se vazio
		echo "</div>";
		?></br><?php
//------------FECHA AltCmdOrm

//------------INICIA delCmdOrm
	$grava_txtDtCria  = "txtDtCria";
	$grava_txtDtAlt = "txtDtAlt";
	$grava_token = "token";
	$grava_ = "\$grava_";
	
	
	//Mostra codigo mysql criação tabela------------
	$tabela = "tb_".$_SESSION['name_bd'];
	
	//echo ")"; 
	?>
	//-----</br><?php //Fecha tabela
	?></br><?php
	$cont_0 = 0;
	$cont_1 = 0;
	$cont_2 = 0;
	$cont_3 = 0;
	$cont_4 = 0;
	$cont_5 = 0;
	
	//Fecha codigo mysql criação tabela------------
	foreach($_POST as $nome_campo => $valor){ 
		$comando = "\$" . $valor . ";"; 
		$post = "\$_REQUEST"; 
		$get = "\$_REQUEST"; 
		$idr = "idr"; 
		$idr_var = "\$idr"; 
		$grava = "\$grava_"; 
		
	   //incrementa 1 blc for
		if($cont_1 == 0){
		//Define Cabeçalho -----
			echo '<div style="color: black;">';
			$cont_1 = 1;
			$comando1 = "include_once '/data/conexao.php';";
			$comando2 = "if(!empty(" . $get . "['".$idr."'])){";
			echo "function delCad".$_SESSION['name_bd']." () { "; ?></br><?php //Abre função de alteração
			echo "header('Content-Type: text/html; charset=iso-8859-1',true);";?></br><?php //Implementa Charset
			echo $comando1; ?></br><?php 
			echo $comando2; ?></br><?php
			echo "try{"; 
			
		}
		if($cont_2 == 0){
		//Define data -----
			$cont_2 = 1;
			//echo $grava_.$grava_txtDtCria . " = date('Y-m-d | h:i:sa');";
			//echo $grava_.$grava_txtDtAlt . " = strip_tags(trim(" . $post . "['dtAlt']));";?></br><?php
			echo $idr_var . " = strip_tags(trim(" . $get . "['" . $idr . "']));";?></br><?php			
		}
		//echo $grava . $valor . " = strip_tags(trim(" . $post . "['" . $valor . "']));";
		eval($comando); 
		//echo $comando; 
	}//---FIM FOREACH
	
		if($cont_3 == 0){
			$cont_3 = 1;
			$sql = "\$sql";
			$tabela = "tb_".$_SESSION['name_bd'];
		//Prepara UPDATE into
			echo  $sql. " = ' DELETE FROM " . $tabela; //Imprime MYSQL
			
		}
		//Inclui data UPDATE		
		echo " WHERE id = :id';";
		//---Inicia VALUES
		//$tabela = "";?></br><?php
		
		//Inicia prepare
		$sql = "\$sql";
		$incluir = "\$delete ";
		$conecta = "\$conecta ";
		
		echo $incluir ."=". $conecta . "->prepare(". $sql. ");";?></br><?php
		foreach($_POST as $nome_campo => $valor){
		   $comando = "\$" . $valor . "='" . 0 . "';"; 
		   //incrementa 1 blc for
		   // Popular array.
			if($cont_5 == 0){
			//Define data -----
				$cont_5 = 1;
				echo $incluir . "->bindValue(':id',$" . $idr . ",PDO::PARAM_STR); ";
				//echo $incluir . "->bindValue(':grava_" . $grava_txtDtAlt . "',$grava_" . $grava_txtDtAlt . ",PDO::PARAM_STR); "; ?></br><?php
				//echo $incluir . "->bindValue(':grava_" . $grava_token . "',$grava_" . $grava_token . ",PDO::PARAM_STR); "; 
			}
			//echo $incluir . "->bindValue(':grava_" . $valor . "',$grava_" . $valor . ",PDO::PARAM_STR); "; 
		}
		//Fecha prepare
		// Inicia incluir
		$incluir = "\$delete";
		$error = "\$error";
		$href = '<a href="http://localhost/record/index.php">Voltar<a>';
		
		echo $incluir . "->execute();";?></br><?php
		echo "}";?></br><?php
		echo "catch(PDOException" . $error ."){ echo" . $error . "->getMessage(); }";?></br><?php
		echo "header('Location:../record/index.php?msg=Excluído com Sucesso');";?></br><?php //
		echo "}else{";?></br><?php
		echo "<a href=''>echo 'Campo Vázio --> Voltar<a>'; }";?></br><?php
		echo "}";?></br><?php// Fecha 
		echo "}";?></br></br><?php// Fecha Validador condicional se vazio
		echo " Correção para acentuação no bd = x = utf8_decode(x);";?></br><?php// Fecha Validador condicional se vazio
		echo '</div>';

//------------FECHA delCmdOrm

	//Mostra codigo mysql criação tabela------------

	
?></br><?php
	$cont_0 = 0;
	$cont_1 = 0;
	$cont_2 = 0;
	$cont_3 = 0;
	$cont_4 = 0;
	$cont_5 = 0;
	
	//Fecha codigo mysql criação tabela------------
	foreach($_POST as $nome_campo => $valor){ 
		$comando3 = 'value=" ?php'.$valor.'"?></br>';
		echo $comando3;
	}
		
}

?>