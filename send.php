<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: same-origin');

require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$nome      = trim($data['nome'] ?? '');
$cognome   = trim($data['cognome'] ?? '');
$email     = trim($data['email'] ?? '');
$telefono  = trim($data['telefono'] ?? '');
$tipologia = trim($data['tipologia'] ?? '');
$indirizzo = trim($data['indirizzo'] ?? '');
$messaggio = trim($data['messaggio'] ?? '');
$formType  = trim($data['formType'] ?? 'hero');

if (!$nome || !$email || !$messaggio) {
    http_response_code(400);
    echo json_encode(['error' => 'Campi obbligatori mancanti']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email non valida']);
    exit;
}

$subject = $formType === 'hero'
    ? "Richiesta valutazione gratuita da {$nome} {$cognome}"
    : "Nuova richiesta di contatto da {$nome} {$cognome}";

$tipologiaRow = $tipologia ? "<tr><td style='padding:8px;border:1px solid #ddd'><strong>Tipologia</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($tipologia) . "</td></tr>" : '';
$indirizzoRow = $indirizzo ? "<tr><td style='padding:8px;border:1px solid #ddd'><strong>Indirizzo</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($indirizzo) . "</td></tr>" : '';

$adminHtml = "
<h2>" . htmlspecialchars($subject) . "</h2>
<table style='border-collapse:collapse;width:100%'>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Nome</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($nome . ' ' . $cognome) . "</td></tr>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Email</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($email) . "</td></tr>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Telefono</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($telefono ?: '—') . "</td></tr>
  {$tipologiaRow}
  {$indirizzoRow}
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Messaggio</strong></td><td style='padding:8px;border:1px solid #ddd'>" . nl2br(htmlspecialchars($messaggio)) . "</td></tr>
</table>
";

$confirmHtml = "
<h2>Grazie per averci contattato, " . htmlspecialchars($nome) . "!</h2>
<p>Abbiamo ricevuto la tua richiesta e ti risponderemo il prima possibile.</p>
<p>Di seguito il riepilogo del tuo messaggio:</p>
<table style='border-collapse:collapse;width:100%'>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Nome</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($nome . ' ' . $cognome) . "</td></tr>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Email</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($email) . "</td></tr>
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Telefono</strong></td><td style='padding:8px;border:1px solid #ddd'>" . htmlspecialchars($telefono ?: '—') . "</td></tr>
  {$tipologiaRow}
  {$indirizzoRow}
  <tr><td style='padding:8px;border:1px solid #ddd'><strong>Messaggio</strong></td><td style='padding:8px;border:1px solid #ddd'>" . nl2br(htmlspecialchars($messaggio)) . "</td></tr>
</table>
";

// Use PHPMailer if available (composer require phpmailer/phpmailer), else fallback to mail()
$vendorAutoload = __DIR__ . '/vendor/autoload.php';

try {
    if (file_exists($vendorAutoload)) {
        require_once $vendorAutoload;
        $mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host       = SMTP_HOST;
        $mailer->SMTPAuth   = true;
        $mailer->Username   = SMTP_USER;
        $mailer->Password   = SMTP_PASS;
        $mailer->SMTPSecure = SMTP_PORT === 465 ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port       = SMTP_PORT;
        $mailer->CharSet    = 'UTF-8';
        $mailer->isHTML(true);

        // Admin email
        $mailer->setFrom(SMTP_FROM, 'Aurora Immobiliare');
        $mailer->addReplyTo($email, $nome . ' ' . $cognome);
        $mailer->addAddress(SMTP_TO);
        $mailer->Subject = $subject;
        $mailer->Body    = $adminHtml;
        $mailer->send();

        // Confirmation to user
        $mailer->clearAddresses();
        $mailer->clearReplyTos();
        $mailer->addAddress($email, $nome);
        $mailer->Subject = 'Abbiamo ricevuto la tua richiesta';
        $mailer->Body    = $confirmHtml;
        $mailer->send();
    } else {
        // Fallback: PHP mail()
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . SMTP_FROM . "\r\n";
        $headers .= "Reply-To: {$email}\r\n";

        mail(SMTP_TO, $subject, $adminHtml, $headers);
        mail($email, 'Abbiamo ricevuto la tua richiesta', $confirmHtml, $headers);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore durante l\'invio. Riprova più tardi.']);
}
