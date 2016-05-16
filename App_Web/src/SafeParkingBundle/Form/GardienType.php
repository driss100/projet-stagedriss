<?php

namespace SafeParkingBundle\Form;

use SafeParkingBundle\Repository\GarageRepository;
use SafeParkingBundle\Repository\GardienRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GardienType extends AbstractType
{
    protected $proprietaire;

    public function __construct($proprietaire)
    {
        $this->proprietaire = $proprietaire;
    }

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
            ->add('parking', 'entity', array(
                'class' => 'SafeParkingBundle:Garage',
                'query_builder' => function(GarageRepository $gr){
                    return $gr->createQueryBuilder('g')
                        ->where('g.proprietaire = :prop')
                        ->setParameter('prop', $this->proprietaire)
                        ;
                },
                'label' => 'Garage :'))
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
            'data_class' => 'SafeParkingBundle\Entity\Gardien'
        ));
    }
}
