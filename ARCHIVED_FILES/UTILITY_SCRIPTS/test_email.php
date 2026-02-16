<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw(
        'Test email from Laravel\n\nThis is a test message to check Gmail SMTP configuration.',
        function ($m) {
            $m->to('21012521@st.phenikaa-uni.edu.vn')
              ->subject('Test Email from Admin Showroom');
        }
    );
    echo "✓ Email sent successfully!\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
}
