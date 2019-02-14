<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('prenom')
        ->add('nom')
        ->add('email',EmailType::class)
        ->add('avatar',UrlType::class,['data'=>'images/pupil/characters/1.png', 'disabled'=>true])
        ->add('password', RepeatedType::class, [
            'constraints'=>[ new NotBlank()],
            'type'=> PasswordType::class,
            'invalid_message'=>'les mots de passe sont differents',
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
        ])
        ->add('estEnseignant', ChoiceType::class,
        ['choices'=>[
            'enfant'=>false,
            'enseignant'=>true
        ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
