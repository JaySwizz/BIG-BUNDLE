<?php
function send_email($to, $subject, $message) {
    $headers = "From: no-reply@bigbundle.com\r\nContent-Type: text/html;";
    mail($to, $subject, $message, $headers);
}
?>
