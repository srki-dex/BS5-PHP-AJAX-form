<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = isset($_POST['name']) ? trim(filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : '';
    $email   = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $message = isset($_POST['message']) ? trim(filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : '';

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Molimo vas da popunite sva polja."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Neispravna email adresa."]);
        exit;
    }

    $to      = "";
    $subject = "Nova poruka sa sajta od: " . $name;
    
    $body    = "Fitnes Klub - " . $name . ":\n\n";
    $body   .= "Ime: " . $name . "\n";
    $body   .= "Email: " . $email . "\n\n";
    $body   .= "Poruka:\n" . $message . "\n";

    $headers  = "From: no-reply@" . $_SERVER['SERVER_NAME'] . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["status" => "success", "message" => "Hvala! Vaša poruka je uspešno poslata."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Došlo je do greške prilikom slanja poruke."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Nevažeći zahtev."]);
}
?>