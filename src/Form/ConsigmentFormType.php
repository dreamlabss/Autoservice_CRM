<?php

namespace App\Form;

use App\Entity\Consignment;
use App\Form\Model\ConsignmentFormModel;
use Form\Model\ConsigmentFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsigmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model',null,['label'=>false])
            ->add('brand',null,['label'=>false])
            ->add('releaseDate',null,['label'=>false])
            ->add('vin',null,['label'=>false])
            ->add('name',null,['label'=>false])
            ->add('surname',null,['label'=>false])
            ->add('midName',null,['label'=>false])
            ->add('phone',null,['label'=>false])
            ->add('service',null,['label'=>false])
            ->add('address',null,['label'=>false])
            ->add('date',null,['label'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConsignmentFormModel::class,
        ]);
    }
}
