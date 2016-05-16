<?php
/**
 * Created by PhpStorm.
 * User: Hamza
 * Date: 15/05/2016
 * Time: 14:07
 */

namespace SafeParkingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GarageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label'=>'Nom :'))
            ->add('latitude', TextType::class, array('label'=>'Latitude :'))
            ->add('longitude', TextType::class, array('label'=>'Longitude :'))
            ->add('nbPlaceTotal', IntegerType::class, array('label'=>'Nombre de place :'))
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
            'data_class' => 'SafeParkingBundle\Entity\Garage'
        ));
    }
}
