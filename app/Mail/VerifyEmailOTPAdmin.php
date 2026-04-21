<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailOTPAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $email,
        public string $name,
        public string $username,
        public string $requestedRole
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: '21012521@st.phenikaa-uni.edu.vn',
            subject: '🔐 Yêu Cầu Xác Thực Tài Khoản Nhân Viên - ' . $this->username,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.verify-otp-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
