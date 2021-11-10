<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

//Klasa RegistrationFormType
//  tworzy typ formularza Registration

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class, [
                'label' => 'Imię użytkownika'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko użytkownika'
            ])
            ->add('number', TelType::class, [
                'label' => 'Numer telefonu użytkownika',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź numer telefonu',
                    ]),
                    new Length([
                        'min' => 9,
                        'minMessage' => 'Twój numer telefonu ma zawierać {{ limit }} cyfer',
                        // max length allowed by Symfony for security reasons
                        'max' => 9,
                    ]),
                ]
            ])
            ->add('typeUser', ChoiceType::class, [
                'choices' => [
                    'firma' => 'firma',
                    'insywidualny' => 'indywidualny'
                ],
              //  'label' => 'Wpisz typ użytkownika',
               // 'help' => 'Wpisz firma albo indywidualny'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Zgoda na przetważanie danych osobowych',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Powinieneś zgodzić się na nasze warunki.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Twoje hasło ma zawierać {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
