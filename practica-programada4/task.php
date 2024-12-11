<?php
require 'db.php';

function crearTarea($user_id, $title, $description, $due_date)
{
    global $pdo;
    try {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date) values (:user_id, :title, :description, :due_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date
        ]);
        return $pdo->lastInsertId();
    } catch (Exception $e) {
        logError("Error creando tarea: " . $e->getMessage());
        return 0;
    }
}

function editarTarea($id, $title, $description, $due_date)
{
    global $pdo;
    try {
        $sql = "UPDATE tasks set title = :title, description = :description, due_date = :due_date where id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'id' => $id
        ]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        logError($e->getMessage());
        return false;
    }
}

function obtenerTareasPorUsuario($user_id)
{
    global $pdo;
    try {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        logError("Error al obtener tareas: " . $e->getMessage());
        return [];
    }
}

function eliminarTarea($id)
{
    global $pdo;
    try {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        logError("Error al eliminar tarea: " . $e->getMessage());
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');
session_start();
if(isset($_SESSION['user_id'])){
    //el usuario tiene sesion
    $user_id = $_SESSION['user_id'];
    logDebug($user_id);
    switch ($method) {
        case 'GET':
            //devolver las tareas del usuario conectado
            $tareas = obtenerTareasPorUsuario($user_id);
            echo json_encode($tareas);
            break;
        
        default:
            http_response_code(405);
            echo json_encode(["error"=> "Metodo no permitido"]);
            break;
    }

}else{
    http_response_code(401);
    echo json_encode(["error" => "Sesion no activa"]);
}
?>
