<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, ['label'=>'Your first name'])
            ->add('lastName', null, ['label'=>'Your last name'])
            ->add('username', null, ['label'=>'Your username'])
            ->add('email', EmailType::class, ['label'=>'Your email'])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'required'=> true,
                'invalid_message'=>'your password fields must match',
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'Confirm password']
            ])
            ->add('submit',SubmitType::class, ["label"=>"Create an account"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
