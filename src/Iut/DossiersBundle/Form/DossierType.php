<?php

namespace Iut\DossiersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Iut\DossiersBundle\Entity\Etat;
use Iut\DossiersBundle\Entity\Vacataire;
use Iut\DossiersBundle\Entity\Piece;
use Iut\DossiersBundle\Entity\Formation;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DossierType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('etat', EntityType::class, [
                    'class' => Etat::class,
                    'choice_label' => "libelle",
                    'multiple' => false])
                ->add('vacataire', EntityType::class, [
                    'class' => Vacataire::class,
                    'choice_label' => "nom",
                    'multiple' => false])
                ->add('pieces', EntityType::class, [
                    'class' => Piece::class,
                    'choice_label' => "libelle",
                    'multiple' => true])
                ->add('formation', EntityType::class, [
                    'class' => Formation::class,
                    'choice_label' => "libelle",
                    'multiple' => false])
                ->add('submit', SubmitType::class, [
                    'attr' => ['class' => "btn btn-primary"]
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Iut\DossiersBundle\Entity\Dossier'
        ));
    }

}
