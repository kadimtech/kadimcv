<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// تحقق من وجود ملفات PHPMailer
if (!file_exists('PHPMailer/src/Exception.php') || 
    !file_exists('PHPMailer/src/PHPMailer.php') || 
    !file_exists('PHPMailer/src/SMTP.php')) {
    die("خطأ: ملفات PHPMailer غير موجودة في المسار الصحيح.");
}

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // إعدادات الخادوم
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kadimtech@gmail.com'; // استبدل ببريدك
        $mail->Password = 'passsword';    // استبدل بكلمة مرور التطبيق
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // إعداد البريد
        $mail->setFrom($email, $name);
        $mail->addAddress('kadimtech@gmail.com');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(false);
        $mail->Subject = "رسالة جديدة من موقعك الشخصي من $name";
        $mail->Body = "الاسم: $name\nالبريد الإلكتروني: $email\nالرسالة:\n$message";
        $mail->CharSet = 'UTF-8';

        $mail->send();
        header("Location: index.html?status=success#contact");
        exit();
    } catch (Exception $e) {
        header("Location: index.html?status=error&message=" . urlencode("فشل الإرسال: {$mail->ErrorInfo}") . "#contact");
        exit();
    }
} else {
    header("Location: index.html");
    exit();
}
?>
