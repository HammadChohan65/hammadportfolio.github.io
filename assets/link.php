
<form action="send-email.php" method="post" enctype="multipart/form-data">

<?php
// recipient email address
$to = 'example@gmail.com';

// subject of the email
$subject = 'Mail From Worxdtf User';

// message body
$content = 'First Name:'.$_POST['first_name'].'\n Last Name: '.$_POST['last_name'].'\n Phone: '.$_POST['phone'].'\n Email: '.'\n Message: '.$_POST['message'];

// from
$from = $_POST['email'];

// boundary
$boundary = uniqid();

// header information
$headers = "From: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\".$boundary.\"\r\n";

// attachment
$file = $_FILES["attachment"]["tmp_name"];
$filename = $_FILES["attachment"]["name"];
$attachment = chunk_split(base64_encode(file_get_contents($file)));

// message with attachment
$content = "--".$boundary."\r\n";
$content .= "Content-Type: text/plain; charset=UTF-8\r\n";
$content .= "Content-Transfer-Encoding: base64\r\n\r\n";
$content .= chunk_split(base64_encode($content));
$content .= "--".$boundary."\r\n";
$content .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
$content .= "Content-Transfer-Encoding: base64\r\n";
$content .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$content .= $attachment."\r\n";
$content .= "--".$boundary."--";

// send email
if (mail($to, $subject, $content, $headers)) {
    echo "Email with attachment sent successfully.";
} else {
    echo "Failed to send email with attachment.";
}
?>