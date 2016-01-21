<?php

namespace Iut\DossiersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Iut\DossiersBundle\Entity\Etat;

class DossierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etat', EntityType::class, [
                    'class' => Etat::class,
                    'choice_label' => "libelle",
                    'multiple' => false])
            ->add('vacataire')
            ->add('pieces')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Iut\DossiersBundle\Entity\Dossier'
        ));
    }
}
