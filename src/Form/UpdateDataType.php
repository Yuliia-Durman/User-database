<?php

namespace App\Form;

use App\Controller\EditRegistrationDateController;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints as Assert;

//Klasa RegistrationFormType
//  tworzy typ formularza UpdateDataType

class UpdateDataType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Hasło',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Hasło ma zawierać {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Imię',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź imię użytkownika',
                    ]),
                ]
              ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź nazwisko użytkownika',
                    ]),
                ]
              ])
            ->add('number', TelType::class, [
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
                'label' => 'Wybierz typ użytkownika',
                'choices' => [
                    'firma' => 'firma',
                    'indywidualny' => 'indywidualny'
                ]
                ]);
            //->add('typeUser', TextType::class, [
            //    'label' => 'firma',
            //    'required' => false 
            //])
            //;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
