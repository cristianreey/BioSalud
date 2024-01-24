<?php
namespace controller;

header('Content-Type: text/html; charset=UTF-8');

use bd\model\Farmacia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '..\PHPMailer-master\PHPMailer-master\src\PHPMailer.php';
require '..\PHPMailer-master\PHPMailer-master\src\Exception.php';
require '..\PHPMailer-master\PHPMailer-master\src\SMTP.php';


class Cliente
{
    public static function registrarCliente($nombre, $email, $password, $fechaNacimiento, $dni, $telefono)
    {
        $pdo = Farmacia::conectar();

        // Validar los datos (realiza validaciones más robustas según tus necesidades)
        if (empty($nombre) || empty($email) || empty($password) || empty($fechaNacimiento) || empty($dni) || empty($telefono)) {
            return "Por favor, complete todos los campos.";
        } else {
            try {
                // Generar código de activación
                $codigoActivacion = bin2hex(random_bytes(16)); // 16 bytes para obtener una cadena de 32 caracteres hexadecimal

                // Hash de la contraseña (mejora la seguridad almacenando contraseñas de manera segura)
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Definir el valor predeterminado para el campo activo como false
                $activo = false;

                // Utilizar prepared statements para evitar inyección SQL
                $stmt = $pdo->prepare("INSERT INTO clientes (nombre, gmail, contrasena, DNI, fechaNac, telefono, activo, codigo_activacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $nombre);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $hashedPassword);
                $stmt->bindParam(4, $dni);
                $stmt->bindParam(5, $fechaNacimiento);
                $stmt->bindParam(6, $telefono);
                $stmt->bindParam(7, $activo, \PDO::PARAM_BOOL);
                $stmt->bindParam(8, $codigoActivacion);

                if ($stmt->execute()) {
                    // Enviar el código de activación por correo electrónico usando PHPMailer
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'biosalud422@gmail.com';
                    $mail->Password = 'cbit ysar gtoq bwpl';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->SMTPDebug = 2;

                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';

                    $mail->setFrom('biosalud422@gmail.com', 'BioSalud');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = mb_encode_mimeheader('Código de Activación', 'UTF-8');
                    $mail->Body = "Su código de activación es: $codigoActivacion";

                    $mail->send();

                    return "Registro exitoso. Se ha enviado un código de activación a su correo electrónico.";
                } else {
                    return "Error al registrar: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                return "Error al registrar: " . $e->getMessage();
            } catch (Exception $e) {
                return "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        }
    }

    public static function verificarCodigoActivacion($codigoActivacion, $email)
    {
        $pdo = Farmacia::conectar();

        try {
            // Consulta para verificar el código de activación
            $stmt = $pdo->prepare("SELECT activo FROM clientes WHERE gmail = :email AND codigo_activacion = :codigo");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':codigo', $codigoActivacion);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['activo'] == 0) {
                // Código de activación correcto y el usuario no está activo
                // Ahora puedes activar al usuario (actualizar la columna 'activo' a 1)
                $stmtUpdate = $pdo->prepare("UPDATE clientes SET activo = 1 WHERE gmail = :email");
                $stmtUpdate->bindParam(':email', $email);
                $stmtUpdate->execute();

                return true;
            } else {
                // Código de activación incorrecto o el usuario ya está activo
                return false;
            }
        } catch (PDOException $e) {
            // Manejar errores si es necesario
            return false;
        }
    }


}
?>