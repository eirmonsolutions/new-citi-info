<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ListingAdminCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $plainPassword;

    public function __construct(User $user, string $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Your Admin Login Credentials')
            ->view('emails.listing_admin_credentials')
            ->with([
                'user' => $this->user,
                'plainPassword' => $this->plainPassword,
                'name' => $this->user->name,
            ]);
    }
}
