document.addEventListener('DOMContentLoaded', function () {

    const tasks = [
        {
            id: 1,
            title: "Complete project report",
            description: "Prepare and submit the project report",
            dueDate: "2024-12-01",
            comments: ["World of Warcraft", "Arthas Menethil: ¡La Agonía de Escarcha está hambrienta!"]
        },
        {
            id: 2,
            title: "Team Meeting",
            description: "Get ready for the season",
            dueDate: "2024-12-01",
            comments: ["World of Warcraft", "Illidan tempestira: ¡No estais preparados!"]
        },
        {
            id: 3,
            title: "Code Review",
            description: "Check partner's code",
            dueDate: "2024-12-01",
            comments: ["World of Warcraft", "Sylvanas Brisaveloz: ¡El árbol del mundo es nuestro!"]
        }
    ];

    function loadTasks() {
        const taskList = document.getElementById('task-list');
        taskList.innerHTML = '';
        tasks.forEach(function (task, index) {
            const taskCard = document.createElement('div');
            taskCard.className = 'col-md-4 mb-3';
            // Modificación en cada comentario para incluir un div de clase "comment-item"
            taskCard.innerHTML = `
<div class="card" style="background-color: ${getBackgroundColor(index)};">
    <div class="card-body">
        <h5 class="card-title">${task.title}</h5>
        <p class="card-text">${task.description}</p>
        <p class="card-text"><small class="text-muted">Due: ${task.dueDate}</small></p>
        <div class="comments-section">
            <ul id="comments-list-${task.id}" class="list-unstyled">
                ${task.comments.map((comment, idx) => `
                    <li class="comment-item d-flex justify-content-between align-items-center p-2 my-2">
                        <span>${comment}</span>
                        <button class="btn btn-sm btn-outline-danger delete-comment" data-task-id="${task.id}" data-comment-index="${idx}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </li>`).join('')}
            </ul>
            <input type="text" class="form-control mb-2" placeholder="Add a comment" id="comment-input-${task.id}">
            <button class="btn btn-sm btn-primary add-comment" data-id="${task.id}">Add Comment</button>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <button class="btn btn-secondary btn-sm edit-task" data-id="${task.id}">Edit</button>
        <button class="btn btn-danger btn-sm delete-task" data-id="${task.id}"><i class="fas fa-trash"></i></button>
    </div>
</div>
`;

            taskList.appendChild(taskCard);
        });

        document.querySelectorAll('.add-comment').forEach(function (button) {
            button.addEventListener('click', handleAddComment);
        });

        document.querySelectorAll('.edit-task').forEach(function (button) {
            button.addEventListener('click', handleEditTask);
        });

        document.querySelectorAll('.delete-task').forEach(function (button) {
            button.addEventListener('click', handleDeleteTask);
        });

        document.querySelectorAll('.delete-comment').forEach(function (button) {
            button.addEventListener('click', handleDeleteComment);
        });
    }

    // Función para asignar colores de fondo según el índice de la tarea
    function getBackgroundColor(index) {
        const colors = ["#f8f9fa", "#e9ecef", "#dee2e6"];  // Colores de fondo claros
        return colors[index % colors.length];
    }


    function handleEditTask(event) {
        //abrir el modal y mostrar los datos
        alert(event.target.dataset.id);
    }


    function handleDeleteTask(event) {
        alert(event.target.dataset.id);
    }

    document.getElementById('task-form').addEventListener('submit', function (e) {
        e.preventDefault();
        alert("crear tarea");
        //TODO: 
        //1. obtener los datos de la tarea
        //2. agregar una tarea al array de tareas
        //3. llamar a load task

    });

    // Función para manejar la adición de comentarios
    function handleAddComment(event) {
        const taskId = event.target.dataset.id;
        const commentInput = document.getElementById(`comment-input-${taskId}`);
        const commentText = commentInput.value.trim();

        if (commentText) {
            const commentsList = document.getElementById(`comments-list-${taskId}`);
            const commentItem = document.createElement('li');
            commentItem.textContent = commentText;
            commentsList.appendChild(commentItem);

            // Limpia el campo de texto del comentario
            commentInput.value = '';
        }
    }

    // Función para manejar la eliminación de comentarios
    function handleDeleteComment(event) {
        const taskId = event.target.dataset.taskId;
        const commentIndex = event.target.dataset.commentIndex;

        // Encuentra la tarea y elimina el comentario en el índice dado
        const task = tasks.find(t => t.id == taskId);
        if (task && task.comments[commentIndex]) {
            task.comments.splice(commentIndex, 1); // Elimina el comentario del array de tareas
            loadTasks(); // Recarga la lista de tareas para actualizar la vista
        }
    }

    loadTasks();

});