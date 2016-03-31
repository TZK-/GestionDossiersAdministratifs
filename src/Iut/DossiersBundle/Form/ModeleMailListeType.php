<?php

namespace Iut\DossiersBundle\Form;

use Iut\DossiersBundle\Entity\ModeleMail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleMailListeType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('titre', EntityType::class, [
                'class' => ModeleMail::class,
                'choice_label' => "titre",
                'multiple' => false])
            ->add('submit', SubmitType::class, ['label' => "Choisir ce modèle"]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Iut\DossiersBundle\Entity\ModeleMail'
        ));
    }

}
