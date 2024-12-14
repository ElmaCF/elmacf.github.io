<?php
// Pastikan hanya dijalankan ketika ada POST data 'g-recaptcha-response'
if (isset($_POST['g-recaptcha-response'])) {
    // Endpoint untuk memverifikasi Recaptcha
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    // Data yang akan dikirim dalam POST request
    $postData = [
        'secret' => '6LdwNAAqAAAAAAVmkQ8I6A7mDc6ljCm6rreigHCh',
        'response' => $_POST['g-recaptcha-response']
    ];

    // Inisialisasi cURL session
    $ch = curl_init($verifyUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi request dan dapatkan respons
    $response = curl_exec($ch);

    // Periksa untuk kesalahan Curl
    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    // Tutup koneksi Curl
    curl_close($ch);

    // Dekode respons JSON
    $result = json_decode($response);

    // Periksa apakah validasi berhasil
    if ($result && isset($result->success) && $result->success === true) {
        return true;
    } else {
        return false;
    }
} else {
    // Jika tidak ada POST data 'g-recaptcha-response'
    return false;
}
?>
