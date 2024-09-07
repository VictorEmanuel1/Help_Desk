<?php

// 	session_start();

// 	//variavel que verifica se a autenticacao foi realizada
// 	$usuario_autenticado = false;
// 	$usuario_id = null;
// 	$usuario_perfil_id = null;

// 	$perfis = array(1 => 'Administrativo', 2 => 'Usuário');

// 	//usuarios do sistema
// 	$usuarios_app = array(
// 		array('id' => 1, 'email' => 'adm@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
// 		array('id' => 2, 'email' => 'user@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
// 		array('id' => 3, 'email' => 'jose@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
// 		array('id' => 4, 'email' => 'maria@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
// 	);

// 	/*
// 	echo '<pre>';
// 	print_r($usuarios_app);
// 	echo '</pre>';
// 	*/

// 	foreach($usuarios_app as $user) {

// 		if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
// 			$usuario_autenticado = true;
// 			$usuario_id = $user['id'];
// 			$usuario_perfil_id = $user['perfil_id'];
// 		}

// 	}

// 	if($usuario_autenticado) {
// 		// echo 'Usuário autencicado';
// 		$_SESSION['autenticado'] = 'SIM';
// 		$_SESSION['id'] = $usuario_id;
// 		$_SESSION['perfil_id'] = $usuario_perfil_id;
// 		header('Location: home.php');
// 	} else {
// 		$_SESSION['autenticado'] = 'NAO';
// 		header('Location: index.php?login=erro');
// 	}



// 	/*
// 	print_r($_GET);

// 	echo '<br />';

// 	echo $_GET['email'];
// 	echo '<br />';
// 	echo $_GET['senha'];
// 	*/

// 	/*
// 	print_r($_POST);

// 	echo '<br />';

// 	echo $_POST['email'];
// 	echo '<br />';
// 	echo $_POST['senha'];
// 	*/
// 

session_start();

// Variáveis para controle de autenticação
$usuario_autenticado = false;
$usuario_id = null;
$usuario_perfil_id = null;

// Função para validar o acesso do usuário
function validarAcesso($email, $senha) {
    // Verifica se o arquivo de usuários existe e é legível
    if (file_exists('usuarios.txt')) {
        $usuarios = file('usuarios.txt', FILE_IGNORE_NEW_LINES);
    } else {
        return false;
    }
    
    $usuario_id = 1; // ID inicial para o usuário

    foreach ($usuarios as $usuario) {
        $dados = explode(',', $usuario);
        if (count($dados) === 4) { // Certifica-se de que temos 4 elementos
            list($usuario_nome, $usuario_email, $usuario_senha, $usuario_perfil_id) = $dados;
            if ($email === $usuario_email && md5($senha) === $usuario_senha) {
                return array('id' => $usuario_id, 'perfil_id' => $usuario_perfil_id);
            }
        }
        $usuario_id++; // Incrementar o ID para o próximo usuário
    }

    return false;
}

// Verificar a autenticação do usuário
$dados_usuario = validarAcesso($_POST['email'], $_POST['senha']);

if ($dados_usuario) {
    // Usuário autenticado
    $usuario_autenticado = true;
    $usuario_id = $dados_usuario['id'];
    $usuario_perfil_id = $dados_usuario['perfil_id'];

    $_SESSION['autenticado'] = 'SIM';
    $_SESSION['id'] = $usuario_id;
    $_SESSION['perfil_id'] = $usuario_perfil_id;
    header('Location: home.php');
    exit();
} else {
    // Falha na autenticação
    $_SESSION['autenticado'] = 'NAO';
    header('Location: index.php?login=erro');
    exit();
}
?>
