<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .card-register {
            padding: 30px 0 0 0;
            width: 400px;
            margin: 0 auto;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            App Help Desk
        </a>
    </nav>

    <div class="container">    
        <div class="row">

            <div class="card-register">
                <div class="card">
                    <div class="card-header text-center">
                        Registrar-se
                    </div>
                    <div class="card-body">
                        <form action="processa_registro.php" method="post" id="registroForm">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input name="nome" type="text" class="form-control" placeholder="Nome completo" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input name="email" type="email" class="form-control" placeholder="Seu e-mail" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmar_senha">Confirmar Senha:</label>
                                <input name="confirmar_senha" type="password" class="form-control" id="confirmar_senha" placeholder="Confirme a senha" required>
                                <span id="senha-erro" class="error-message"></span>
                            </div>

                            <button class="btn btn-lg btn-success btn-block" type="submit" id="registrarBtn">Registrar</button>

                            <a href="index.php" class="btn btn-lg btn-secondary btn-block">Voltar ao Login</a>

                        </form>

                        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'senha') { ?>
                            <div class="text-danger text-center mt-2">
                                As senhas não correspondem!
                            </div>
                        <?php } ?>
                        
                        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'email') { ?>
                            <div class="text-danger text-center mt-2">
                                E-mail já cadastrado!
                            </div>
                        <?php } ?>

                        <?php if (isset($_SESSION['registro_sucesso']) && $_SESSION['registro_sucesso']) { ?>
                            <script>
                                alert('Registro realizado com sucesso!');
                                window.location.href = 'login.php';
                            </script>
                            <?php unset($_SESSION['registro_sucesso']); // Limpa a variável de sessão após exibir o alerta ?>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Função para verificar se as senhas correspondem em tempo real
        document.getElementById('confirmar_senha').addEventListener('input', function() {
            var senha = document.getElementById('senha').value;
            var confirmarSenha = document.getElementById('confirmar_senha').value;
            var erroSenha = document.getElementById('senha-erro');
            var botaoRegistrar = document.getElementById('registrarBtn');

            // Verificar se as senhas correspondem
            if (senha !== confirmarSenha) {
                erroSenha.textContent = "As senhas não correspondem.";
                botaoRegistrar.disabled = true; // Desabilitar botão de registrar
            } else {
                erroSenha.textContent = ""; // Limpar mensagem de erro
                botaoRegistrar.disabled = false; // Habilitar botão de registrar
            }
        });
    </script>

</body>
</html>
