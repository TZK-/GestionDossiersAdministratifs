<?php

namespace Iut\DossiersBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Iut\DossiersBundle\Entity\ModeleMail;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModeleMailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('message', TextareaType::class, ['required' => false])
            ->add('submit', SubmitType::class, ['label' => "Valider nouveau mail"])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Iut\DossiersBundle\Entity\ModeleMail'
        ));
    }
}
