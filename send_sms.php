<?php
function send_sms($to, $message) {
    // Africastalking or other SMS service would go here
    // This is a placeholder
    // Log instead
    file_put_contents("sms_log.txt", "To: $to\nMessage: $message\n\n", FILE_APPEND);
}
?>
