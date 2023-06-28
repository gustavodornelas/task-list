<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>

<div class="popup" id="popupForm">
    <div class="popup-inner">
        <h2>Nova Tarefa</h2>
        <form id="newTaskForm" action="cadastrar_tarefa.php" method="POST">
            <main>
                <label for="title">Título</label>
                <input type="text" class="border" id="title" name="taskTitle" required>

                <label for="description">Descrição</label>
                <textarea class="border" id="description" name="taskDescription" rows="10" required></textarea>
            </main>

            <footer>
                <button type="submit" class="border">Cadastrar</button>
                <button type="button" class="border" onclick="fecharPopup()">Cancelar</button>
            </footer>
        </form>
    </div>
</div>

<body>
    <header class="header">
        <nav>
            <h1>
                <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                Lista de Tarefas
            </h1>
        </nav>
    </header>

    <main>

        <aside>
            <button class="new border" onclick="novaTarefa()"> Nova tarefa</button>
            <menu class="border">
                <button class="border" id="tarefas-pendentes" onclick="exibirTarefas('p')">Tarefas Pendentes</button>
                <button class="border" id="tarefas-concluidas" onclick="exibirTarefas('f')">Tarefas Concluidas</button>
                <button class="border" id="todas-tarefas" onclick="exibirTarefas('a')">Todas as Tarefas</button>
            </menu>
        </aside>

        <div class="task-container" id="task-container">
            <h1>Tarefas Pendentes</h1>
            <div class="task-display" id="task-display">
                <!-- Tarefas serão inseridas aqui -->
            </div>
        </div>
    </main>

    <script>
        // Carregar as tarefas do banco de dados
        var results;

        function novaTarefa() {
            document.getElementById("popupForm").style.display = "block";
        }

        function fecharPopup() {
            document.getElementById("popupForm").style.display = "none";
        }

        function carregarTarefas() {

            <?php
            require_once('conection.php');

            $stmt = $pdo->query("SELECT * FROM tasks");

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "results = " . json_encode($results) . ";";
            ?>

            console.log(results);
        }

        function finalizarTarefa(id) {
            console.log('delete task: ' + id);

            <?php
            require_once('conection.php');

            $taskId = "<script>document.write(id)</script>";
            $stmt = $pdo->prepare("UPDATE tasks SET status = 'f' WHERE id = :id");
            $stmt->bindParam(':id', $taskId);
            $stmt->execute();
            echo 'console.log("alterado com sucesso")';
            ?>


        }

        function exibirTarefas(status) {
            carregarTarefas();

            const tasksContainer = document.getElementById('task-display');
            tasksContainer.innerHTML = '';

            const tarefasPendentes = document.getElementById('tarefas-pendentes');
            const tarefasConcluidas = document.getElementById('tarefas-concluidas');
            const TodasTarefas = document.getElementById('todas-tarefas');

            tarefasPendentes.classList.remove('active');
            tarefasConcluidas.classList.remove('active');
            TodasTarefas.classList.remove('active');

            if (status == 'p') {
                tarefasPendentes.classList.add('active');
            } else if (status == 'f') {
                tarefasConcluidas.classList.add('active');
            } else if (status == 'a') {
                TodasTarefas.classList.add('active');
            }

            results.forEach(element => {
                if (status === 'a' || status === element.status) {
                    const form = document.createElement('form');
                    form.action = 'finalizar_tarefa.php';
                    form.method = 'POST';

                    const taskIdInput = document.createElement('input');
                    taskIdInput.type = 'hidden';
                    taskIdInput.name = 'taskId';
                    taskIdInput.value = element.id;
                    form.appendChild(taskIdInput);

                    const task = document.createElement('div');
                    task.classList.add('task', 'border');

                    const header = document.createElement('header');

                    const title = document.createElement('h2');
                    title.textContent = element.title;

                    if (element.status == 'f') {
                        title.textContent = element.title + ' (Concluída)';
                    }

                    header.appendChild(title);

                    const description = document.createElement('p');
                    description.textContent = element.description;

                    const footer = document.createElement('footer');

                    if (element.status == 'p') {
                        const button = document.createElement('button');
                        button.classList.add('border');
                        button.type = 'submit';
                        button.textContent = 'Finalizar Tarefa';
                        footer.appendChild(button);

                    } else {

                    }

                    task.appendChild(header);
                    task.appendChild(description);
                    task.appendChild(footer);

                    form.appendChild(task);
                    tasksContainer.appendChild(form);
                }
            });
        }

        exibirTarefas('p');
    </script>

</body>

</html>