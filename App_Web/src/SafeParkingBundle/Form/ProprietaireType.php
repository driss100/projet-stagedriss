<?php

namespace SafeParkingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProprietaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label'=>'Nom :'))
            ->add('prenom', TextType::class, array('label'=>'Prénom :'))
            ->add('email', EmailType::class, array('label'=>'E-mail :'))
            ->add('password', PasswordType::class, array('label'=>'Mot de passe :'))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->add('cancel', SubmitType::class, array(
                'label' => 'Annuler',
                'attr' => array(
                    'formnovalidate' => 'formnovalidate'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SafeParkingBundle\Entity\Proprietaire'
        ));
    }
}
