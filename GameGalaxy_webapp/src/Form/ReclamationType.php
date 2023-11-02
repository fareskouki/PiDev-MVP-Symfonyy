<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre_rec')
            ->add('type_rec')
            ->add('date_rec')
            ->add('contenu_rec')
            ->add('statut_rec')
            ->add('username')
            ->add('commande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
    //sms
    public  function sms(){
        // Your Account SID and Auth Token from twilio.com/console
                $sid = 'ACed59c2efc292602af3f856aad90c6bb6';
                $auth_token = 'f4fc9826d7cb10067d6450dad8321172';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
                $twilio_number = "+12762849300";
        
                $client = new Client($sid, $auth_token);
                $client->messages->create(
                // the number you'd like to send the message to
                    '+21654804772',
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => '+21654804772',
                        // the body of the text message you'd like to send
                        'body' => 'votre reclamation a été traité merci de nous contacter pour plus de détail!'
                    ]
                );
            }
}
