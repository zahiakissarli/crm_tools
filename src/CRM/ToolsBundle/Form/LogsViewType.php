<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogsViewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startDate',
            'date',array(
                'label'     => 'Date début formulaire',
                'widget'    => 'single_text',
                'format'    => 'dd-MM-yyyy',
                'attr' => ['id' => 'date'],
                'attr' => ['name' => 'date'],
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('endDate',
                'date',array(
                    'label'     => 'Date Fin formulaire',
                    'widget'    => 'single_text',
                    'format'    => 'dd-MM-yyyy',
                    'attr'      => array(
                        'class' => 'datepicker')
                ));

//        $builder->add('fileName');
//                ->add('id')
//                ->add('fileNameRoot')
//
//                ->add('startDate')
//                ->add('endDate')
//                ->add('duration')
//                ->add('iteration')
//                ->add('nbrClient')
//                ->add('nbrEvent')
//                ->add('nbrBooking')
//                ->add('fileDate')
//                ->add('graphName')
//                ->add('averageDurationJob')
//                ->add('durationString');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CRM\ToolsBundle\Entity\LogsView'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'crm_toolsbundle_logsview';
    }


}
