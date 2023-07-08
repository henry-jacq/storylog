<?php

namespace App\Services;

use App\Core\Auth;
use App\Core\User;
use App\Core\Database;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Mailer - PHPMailer wrapper for sending emails
 */

class Mailer extends User
{
    public $mailer;

    public function __construct()
    {
        $fromName = APP_NAME;
        $fromAddress = APP_FROM_ADDRESS;
        $smtpHost = SMTP_HOST;
        $smtpPort = 587;
        $smtpAuthUser = SMTP_AUTH_USER;
        $smtpAuthPass = SMTP_AUTH_PASS;
        // Initialize PHPMailer with enabled exceptions.
        $this->mailer = new PHPMailer(true);

        // SMTP Server settings
        // Enable verbose debug output
        // $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailer->isSMTP();
        $this->mailer->Host       = $smtpHost;
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $smtpAuthUser;
        $this->mailer->Password   = $smtpAuthPass;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = $smtpPort;

        $this->mailer->setFrom($fromAddress, $fromName);
    }

    /**
     * Check if the mail exist in database or not
     */
    public static function mailExists(string $email): bool
    {
        $email = User::check_sql_errors($email);
        $query = "SELECT * FROM `auth` WHERE `email` = '$email'";

        // Create a connection to database
        $conn = Database::getConnection();

        // Get the user details [1 row] by sending this query to database.
        $result = $conn->query($query);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            if ($row['email']) {
                return true;
            } else {
                throw new \Exception("Email is not available");
            }
        } else {
            return false;
        }
    }

    // HTML body for password reset mail
    private function passwordResetMailBody($name, $reset_link)
    {
        if (isset($name, $reset_link)) {
            $htmlMailBody = "
            <div style='line-height:1.5rem; margin-bottom:10px;'>
                <b>Hi $name,</b><br>
                We heard that you have lost your Photogram password. Sorry about that.<br>
                But don't worry, You can click on this link to reset your password: <a href='$reset_link'>Reset password</a><br>
                If you don't use the link within 30 minutes, it will expire.<br>
                reset_link visit $reset_link
            </div>
            Thanks,<br>
            <b>Photogram Team</b>
            ";
            return $htmlMailBody;
        } else {
            return false;
        }
    }

    /**
     * Send password-reset mail to the provided email
     */
    public static function sendPasswordResetMail(string $to)
    {
        try {
            $name = ucfirst(User::getUsernameByEmail($to));
            if ($name) {
                // Initialize mailer instance
                $mailer = new Mailer();

                $mailer->addRecipient($to);
                $mailer->addSubject("[Photogram] Reset your password!");
                $reset_link = Auth::createResetPasswordLink($to);
                $html = $mailer->passwordResetMailBody($name, $reset_link);
                $mailer->isHTML(true);
                $mailer->addBody($html);
                $mailer->sendMail();
                return $reset_link;
            }
        } catch (\Exception $e) {
            echo("Mailer Error: {$e->getMessage()}");
        }
    }

    /**
     * The Subject of the message.
     */
    public function addSubject(string $subject)
    {
        $this->mailer->Subject = $subject;
    }

    /**
     * Sets message type to HTML or plain.
     */
    public function isHTML(bool $isHTML)
    {
        $this->mailer->isHTML($isHTML);
    }

    /**
     * An HTML or plain text message body.
     */
    public function addBody(mixed $body)
    {
        $this->mailer->Body = $body;
    }

    /**
     * The plain-text message body.
     *
     * This body can be read by mail clients that do not have HTML email capability such as mutt & Eudora. Clients that can read HTML will view the normal Body.
     */
    public function addAltBody(string $altBody)
    {
        $this->mailer->AltBody = $altBody;
    }

    /**
     * Add an attachment from a path on the filesystem.
     */
    public function addAttachment($attachment, $name = null)
    {
        $this->mailer->addAttachment($attachment, $name);
    }

    /**
     * Add a "To" address.
     *
     * true on success, false if address already used or invalid in some way
     */
    public function addRecipient(string $address, $name = null)
    {
        $this->mailer->addAddress($address, $name);
    }

    /**
     * Create a message and send it.
     *
     * @return bool — false on error - See the ErrorInfo property for details of the error
     * @throws Exception
     */
    public function sendMail()
    {
        $this->mailer->send();
    }

    /**
     * Add a "CC" address.
     */
    public function addCC(string $address)
    {
        $this->mailer->addCC($address);
    }

    /**
     * Add a "BCC" address.
     */
    public function addBCC(string $address)
    {
        $this->mailer->addBCC($address);
    }

    /**
     * Add a "Reply-To" address.
     */
    public function addReplyTo(string $address)
    {
        $this->mailer->addReplyTo($address);
    }
}
