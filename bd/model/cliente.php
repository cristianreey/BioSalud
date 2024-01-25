<?php

namespace controller;

header('Content-Type: text/html; charset=UTF-8');

use bd\model\Farmacia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'conexion.php';
require '..\PHPMailer-master\PHPMailer-master\src\PHPMailer.php';
require '..\PHPMailer-master\PHPMailer-master\src\Exception.php';
require '..\PHPMailer-master\PHPMailer-master\src\SMTP.php';

use PDOException;
use PDO;

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

                $salt = bin2hex(random_bytes(16));

                $saltedPassword = $password . $salt;

                // Hash de la contraseña (mejora la seguridad almacenando contraseñas de manera segura)
                $hashedPassword = hash('sha256', $saltedPassword);

                // Definir el valor predeterminado para el campo activo como false
                $activo = false;

                // Utilizar prepared statements para evitar inyección SQL
                $stmt = $pdo->prepare("INSERT INTO clientes (nombre, gmail, contrasena, DNI, fechaNac, telefono, activo, codigo_activacion, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $nombre);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $hashedPassword);
                $stmt->bindParam(4, $dni);
                $stmt->bindParam(5, $fechaNacimiento);
                $stmt->bindParam(6, $telefono);
                $stmt->bindParam(7, $activo, \PDO::PARAM_BOOL);
                $stmt->bindParam(8, $codigoActivacion);
                $stmt->bindParam(9, $salt);

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
                return "Error al enviar el correo: " . $e->getMessage();
            }
        }
    }

    public static function iniciarSesion($email, $password)
    {
        // Realizar la conexión a la base de datos
        $pdo = Farmacia::conectar();

        if (empty($email) || empty($password)) {
            return "Por favor, complete todos los campos.";
        } else {
            try {
                // Obtener el usuario de la base de datos
                $stmt = $pdo->prepare("SELECT * FROM clientes WHERE gmail = ?");
                $stmt->execute([$email]);

                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    // Verificar si la contraseña hash coincide con la almacenada en la base de datos
                    $saltedPassword = $usuario['contrasena'];
                    $hashedPassword = hash('sha256', $saltedPassword);

                    if ($hashedPassword === $usuario['contrasena']) {
                        return "Inicio de sesión exitoso.";
                    } else {
                        return "El usuario o la contraseña no es correcto.";
                    }
                } else {
                    return "El usuario o la contraseña no es correcto.";
                }
            } catch (PDOException $e) {
                return "Error al iniciar sesión: " . $e->getMessage();
            }
        }
    }




}