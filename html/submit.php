<?php
require 'vendor/autoload.php';

use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir datos del formulario
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $message = $_POST["message"] ?? '';

    // Validación básica
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "All fields are required.";
        exit;
    }

    // Configura tu ARN de SNS (reemplazar XXXXX)
    $snsTopicArn = 'arn:aws:sns:us-east-1:039422425289:Practica-microservicios-con-Docker';

    // Crear cliente SNS
    $snsClient = new SnsClient([
        'version' => 'latest',
        'region'  => 'us-east-1', // Asegúrate de que coincida con tu región AWS
        // 'credentials' => [ // Opcional si usas IAM roles o variables de entorno
        //     'key'    => 'your-access-key',
        //     'secret' => 'your-secret-key',
        // ]
    ]);

    // Mensaje a enviar (JSON)
    $messageToSend = json_encode([
        'email' => $email,
        'name' => $name,
        'message' => $message
    ]);

    try {
        // Publicar en el topic SNS
        $snsClient->publish([
            'TopicArn' => $snsTopicArn,
            'Message'  => $messageToSend
        ]);

        // Conectar a la base de datos (host 'mysql' desde Docker Compose)
        $mysqli = new mysqli("mysql", "my_user", "my_password", "my_database");

        if ($mysqli->connect_error) {
            throw new Exception("MySQL connection failed: " . $mysqli->connect_error);
        }

        // Insertar datos
        $stmt = $mysqli->prepare("INSERT INTO form_data (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        $stmt->execute();

        echo "Message sent and saved successfully.";

    } catch (AwsException $e) {
        http_response_code(500);
        echo "AWS SNS Error: " . $e->getAwsErrorMessage();
    } catch (Exception $e) {
        http_response_code(500);
        echo "Server Error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Método no permitido
    echo "Method Not Allowed";
}
?>
