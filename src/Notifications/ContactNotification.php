<?php

namespace App\Notifications;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactNotification extends AbstractController
{

    /**
     * @var MailerInterface;
     */
    private $mailer;

    /**
     * @var Environment;
     */
    private $twig;

    /**
     * @var Request
     */
    private $request;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(Contact $contact)
    {
        $propertyHeat = $contact->getProperty()::HEAT;

        $datas['firstname'] = $contact->getFirstname();
        $datas['lastname'] = $contact->getLastName();
        $datas['phoneNumber'] = $contact->getPhoneNumber();
        $datas['message'] = $contact->getMessage();
        $datas['property'] = $contact->getProperty();
        $datas['chauffage'] = $propertyHeat[$contact->getProperty()->getHeat()];

        $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('melron@outlook.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($contact->getEmail())
            //->priority(Email::PRIORITY_HIGH)
            ->subject($contact->getProperty()->getTitle())
            ->embedFromPath('../public/images/properties/' . $contact->getProperty()->getImageName(), 'main-image')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'datas' => $datas,
            ]);

        try {
            $this->mailer->send($email);
            $this->addFlash('success', 'votre messsage a bien été envoyé');
        } catch (TransportExceptionInterface $e) {
            $message = $e->getMessage();
            $this->addFlash('error', "L'email n'a pas pu être envoyé: $message");
        }
    }
}
