<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModifyAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class)
            ->add('newPassword',RepeatedType::class, [
                'constraints'=>[ new NotBlank()],
                'type'=> PasswordType::class,
                'invalid_message'=>'les mots de passe sont differents',
                'first_options'  => ['label' => 'nouveau mot de passe'],
                'second_options' => ['label' => 'xomfirmer le nouveau mot de passe'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
