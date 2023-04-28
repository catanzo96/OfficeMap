<?php

namespace App\Form;

use App\Entity\PersonaFisica;
use App\Entity\Utente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le password non corrispondono.',
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'label' => 'Password',
                    'mapped' => false
                ],
                'second_options' => [
                    'label' => 'Conferma password',
                    'mapped' => false
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Inserisci password!',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'La password deve contenere almeno {{ limit }} caratteri.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nome')
            ->add('cognome')
            ->add('codiceFiscale', TextType::class, [
                'attr' => [
                    'maxlength' => 16,
                    'minlength' => 16,
                ]
            ])
            ->add('dataNascita', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('luogoNascita')
            ->add('provinciaNascita')
            ->add('telefono');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            ['data_class' => Utente::class],
            ['data_class' => PersonaFisica::class],
        ]);
    }
}
