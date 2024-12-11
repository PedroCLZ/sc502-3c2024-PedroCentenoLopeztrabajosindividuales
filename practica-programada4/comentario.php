<?php
session_start();
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    switch ($method) {
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['task_id'], $input['content'])) {
                $task_id = $input['task_id'];
                $content = $input['content'];
                $comment_id = crearComentario($task_id, $user_id, $content);
                if ($comment_id) {
                    echo json_encode(["message" => "Comentario creado", "id" => $comment_id]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al crear el comentario"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos"]);
            }
            break;

        case 'GET':
            if (isset($_GET['task_id'])) {
                $task_id = $_GET['task_id'];
                $comentarios = obtenerComentariosPorTarea($task_id, $user_id);
                echo json_encode($comentarios);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "ID de tarea requerido"]);
            }
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['id'], $input['content'])) {
                $id = $input['id'];
                $content = $input['content'];
                if (editarComentario($id, $user_id, $content)) {
                    echo json_encode(["message" => "Comentario actualizado"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al actualizar el comentario"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos"]);
            }
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (eliminarComentario($id, $user_id)) {
                    echo json_encode(["message" => "Comentario eliminado"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al eliminar el comentario"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "ID de comentario requerido"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            break;
    }
} else {
    http_response_code(401);
    echo json_encode(["error" => "Sesión no activa"]);
}

function crearComentario($task_id, $user_id, $content) {
    return rand(1, 1000); // Simular ID de comentario
}

function obtenerComentariosPorTarea($task_id, $user_id) {
    return [
        ["id" => 1, "task_id" => $task_id, "user_id" => $user_id, "content" => "Primer comentario"],
        ["id" => 2, "task_id" => $task_id, "user_id" => $user_id, "content" => "Segundo comentario"]
    ];
}

function editarComentario($id, $user_id, $content) {
    return true;
}

function eliminarComentario($id, $user_id) {
    return true;
}
?>
