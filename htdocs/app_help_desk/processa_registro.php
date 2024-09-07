<?php
// session_start(); // Iniciar a sessão

// // Processa os dados do formulário de registro

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $nome = $_POST['nome'];
//     $email = $_POST['email'];
//     $senha = $_POST['senha'];
//     $confirmar_senha = $_POST['confirmar_senha'];

//     // Exemplo simples de validação
//     if ($senha !== $confirmar_senha) {
//         header('Location: registro.php?erro=senha');
//         exit();
//     }

//     // Simulação de um email já cadastrado (aqui você pode implementar a lógica para verificar no banco de dados ou arquivo)
//     $emails_existentes = ['usuario@example.com']; // Substituir pela verificação real

//     if (in_array($email, $emails_existentes)) {
//         header('Location: registro.php?erro=email');
//         exit();
//     }

//     // Se passar em todas as validações, definir uma variável de sessão para o sucesso do registro
//     $_SESSION['registro_sucesso'] = true;

//     // Redirecionar de volta para a tela de registro
//     header('Location: index.php');
//     exit();
// } else {
//     // Se não for um POST válido, redirecione para a página de registro
//     header('Location: registro.php');
// }


session_start();

// Função para salvar o usuário em um arquivo
function salvarUsuario($nome, $email, $senha, $perfil_id) {
    $dados_usuario = $nome . "," . $email . "," . md5($senha) . "," . $perfil_id . "\n";
    file_put_contents('usuarios.txt', $dados_usuario, FILE_APPEND);
}

// Processa os dados do formulário de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Exemplo simples de validação
    if ($senha !== $confirmar_senha) {
        header('Location: registro.php?erro=senha');
        exit();
    }

    // Verifica se o arquivo de usuários existe e é legível
    $usuarios_existentes = array();
    if (file_exists('usuarios.txt')) {
        $usuarios_existentes = file('usuarios.txt', FILE_IGNORE_NEW_LINES);
    }

    // Verifica se o email já está cadastrado
    foreach ($usuarios_existentes as $usuario) {
        $dados = explode(',', $usuario);
        if (count($dados) === 4) { // Certifica-se de que temos 4 elementos
            list($usuario_nome, $usuario_email, $usuario_senha, $usuario_perfil_id) = $dados;
            if ($email === $usuario_email) {
                header('Location: registro.php?erro=email');
                exit();
            }
        }
    }

    // Se passar em todas as validações, salvar o usuário
    $novo_perfil_id = 2; // Exemplo: definir perfil padrão como 'Usuário'
    salvarUsuario($nome, $email, $senha, $novo_perfil_id);

    // Definir uma variável de sessão para o sucesso do registro
    $_SESSION['registro_sucesso'] = true;

    // Redirecionar de volta para a tela de registro
    header('Location: index.php');
    exit();
} else {
    // Se não for um POST válido, redirecione para a página de registro
    header('Location: registro.php');
    exit();
}
?>
