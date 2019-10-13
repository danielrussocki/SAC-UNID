<?php
require_once $_SERVER["DOCUMENT_ROOT"].'includes/database.php';
use PHPMailer\PHPMailer\PHPMailer;
require $_SERVER["DOCUMENT_ROOT"] . 'vendor/autoload.php';
    if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $row = $db->count("usuarios", "*", 
        [
            "email_usr" => $email
        ]);

        if ($row != 0) {
            $reset = $db->count(
                "password_reset_temp",
                [
                "email" => $email
                ]);

            if ($reset == 0) {
                $expFormat = mktime(
                date("H"),
                date("i"),
                date("s"),
                date("m"),
                date("d")+1,
                date("Y")
            );
                $expDate = date("Y-m-d H:i:s", $expFormat);
                $key = md5(2418*2+$email);
                $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
                $key = $key . $addKey;
                // Insert Temp Table
                $db->insert("password_reset_temp", [
                "email" => $email,
                "key" => $key,
                "expDate" => $expDate
            ]);
                $message='<p>Querido usuario</p>';
                $message = '<p>Hemos recibido una petición para un cambio de contraseña. 
                Aquí encontrara el link para hacer el cambio: <br>';
                $message .='<a href="' . $url . '">'. $url .'</a></p>';
                $message .='<p><a href="http://smoothoperators.com.mx/modulos/login/create-new-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
                 http://www.smoothoperators.com.mx/modulos/login/reset-request.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
                $body = $message;
                $subject = "Restaurar contraseña";
                $email_to = $email;
                $fromserver = "sistemacanones@smoothoperators.com.mx";
                $from_name = "Sistema Cañones";
                $mail = new PHPMailer();
                $mail->CharSet = "utf-8";
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPDebug = 0;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Username = 'sistemacanones@smoothoperators.com.mx';
                $mail->Password = '&7yQ=b&<';
                $mail->From = "sistemacanones@smoothoperators.com.mx";
                $mail->FromName = "Sistema Cañones";
                $mail->Sender = $fromserver;
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->IsHTML(true);
                $mail->AddAddress($email_to);
                if (!$mail->Send()) {
                    header("HTTP/1.0 404 Not Found");
                }
                else {
                    header("Location: /modulos/login/reset-password.php?reset=success");
                }
            }
            else{
                header("HTTP/1.0 404 Not Found");
            }
        }
        else{
            header("HTTP/1.0 404 Not Found");
        } 
    }
    else {
        header('HTTP/1.0 403 Forbidden');
    }
?>