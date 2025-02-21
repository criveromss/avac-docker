<?php

declare(strict_types = 1);

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Twig\Environment;

class MailerService
{

  public function __construct(
    protected Environment $twig,
    protected MailerInterface $mailer
  ) {

  }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void
    {


        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template);

            $email->context($context);

       $this->mailer->send($email);

    }
}
