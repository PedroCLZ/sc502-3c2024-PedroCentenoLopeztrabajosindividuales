<?php
require 'task.php';

$idTarea = crearTarea(1, 'Primer tarea prueba', 'Primer tarea prueba', '2024-11-14');
if ($idTarea) {
    echo 'Tarea creada exitosamente ' . $idTarea;
} else {
    echo 'No se creó la tarea';
}

$editado = editarTarea($idTarea, 'Aprender PHP y MySQL', 'Ampliar conocimiento en CRUD y SQL', '2024-12-15');
if ($editado) {
    echo "Tarea editada exitosamente.\n";
} else {
    echo "Error al editar la tarea.\n";
}

echo "Lista de tareas" . PHP_EOL;
$tareas = obtenerTareasPorUsuario(1);
if ($tareas) {
    foreach ($tareas as $tarea) {
        echo "ID: " . $tarea["id"] . " Titulo: " . $tarea["title"] . PHP_EOL;
    }
}

echo "Eliminando una tarea: " . $idTarea . PHP_EOL;
$eliminado = eliminarTarea($idTarea);
if ($eliminado) {
    echo "La tarea se eliminó exitosamente";
} else {
    echo "Error al eliminar la tarea";
}
?>
