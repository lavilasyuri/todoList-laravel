<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet"  href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body onload="initialyze()">
    <div class="container">
        <h2>Lista de Tarefas</h2>
        <br>
            <form>
                <div class="new-task-container">
                    <input type="text" class="new-task-input" id="new-task-input" placeholder="Digite aqui sua tarefa...">
                    <button class="new-task-button" onclick="saveTask()">Adicionar</button>
                </div>
            </form>
            <div class="tasks-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><h4>Tarefas</h4></th>     
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>   
                    
                </table>
            </div>
    </div>

    <div class="modal fade" id="editionModal" tabindex="-1" role="dialog" aria-labelledby="editionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editionModalLabel">Editar tarefa</h5>
                        </div>
                        <div class="new-task-container">
                            <form>
                                <div class="new-task-input">
                                    <input type="hidden" id="task-id">
                                    <label for="task-description" class="col-form-label">Descrição:</label>
                                    <input type="text" class="form-control" id="task-description">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="task-button" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="new-task-button" data-bs-dismiss="modal" onclick="edit()">Atualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <script type="text/javascript">
        
        function initialyze() {
            getTaskController();
        }

        function getTaskController() {
            $.ajax({
                type: "GET",
                url: "/taskcontroller",
                success: function (data) {
                    console.log(data);
                    if (data.length > 0) {
                        const table = document.getElementsByTagName('tbody')[0];
                        table.innerHTML = "";
                        for (var i = 0; i < data.length; i++) {
                            try {
                                const row = table.insertRow(i);
                                const cell1 = row.insertCell(0);
                                const cell2 = row.insertCell(1);
                                const cell3 = row.insertCell(2);
                                const cell4 = row.insertCell(3);
                                cell1.innerHTML = data[i].description;
                                cell2.innerHTML = `<button class="new-task-button" onclick="openEditModal(${data[i].id},'${data[i].description}')"><i class="fa fa-edit"></i></button>`;
                                cell3.innerHTML = '<button class="task-delete" onclick="deleteTask(' + data[i].id + ')"><i class="fa fa-trash"></i></button>';
                            } catch (error) {
                                console.log(error);
                            }

                        }
                    } else {
                        var row = table.insertRow(0);
                        var cell = row.insertCell(0);
                        cell.innerHTML = 'Sem tarefas';
                    }
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function saveTask() {
            const taskcontroller = document.getElementById('new-task-input').value;
            $.ajax({
                type: "POST",
                url: "/taskcontroller",
                data: {
                    description: taskcontroller
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTaskController();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function deleteTask(id) {
            $.ajax({
                type: "DELETE",
                url: `/taskcontroller/${id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTaskController();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        function openEditModal(id, description) {
            $('#editionModal').modal('show');
            $('#task-id').val(id);
            $('#task-description').val(description);
        }

        function edit() {
            var id = $('#task-id').val();
            var description = $('#task-description').val();
            $.ajax({
                type: "PUT",
                url: `/taskcontroller/${id}`,
                data: {
                    description: description
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    getTaskController();
                },
                error: function (error) {
                    alert(`Error ${error}`);
                }
            })
        }

        
    </script>

    <script src="https://kit.fontawesome.com/f9e19193d6.js" crossorigin="anonymous"></script>
</body>
</html>