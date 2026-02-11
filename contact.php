<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));

    // Check for empty fields
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Proszę wypełnić wszystkie wymagane pola poprawnie.";
        exit;
    }

    // Recipient email
    $recipient = "m.sologuba@mattytrans.eu";

    // Email subject
    $email_subject = "Nowa wiadomość od: $name - $subject";

    // Email content
    $email_content = "Imię i Nazwisko: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Telefon: $phone\n\n";
    $email_content .= "Wiadomość:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($recipient, $email_subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Dziękujemy! Twoja wiadomość została wysłana.";
    } else {
        http_response_code(500);
        echo "Ups! Coś poszło nie tak i nie mogliśmy wysłać Twojej wiadomości.";
    }
} else {
    http_response_code(403);
    echo "Wystąpił problem z Twoim zgłoszeniem, spróbuj ponownie.";
}
?>
