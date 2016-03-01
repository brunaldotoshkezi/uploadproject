<?php

namespace Upload\GFileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
        $builder
            ->add('name', 'text', array(
                    'mapped' => false,
                    'label' => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'required' => true,
                        'multiple' => false  
                    )                    
                ))
            ->add('email', 'email', array(
                    'mapped' => false,
                    'label' => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'required' => true,
                        'multiple' => false  
                    )                    
                ))
            ->add('file',null, array(
                    'label' => false, 
                    'attr'=>array(
                        'required' => true,
                    )
                ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Upload\GFileBundle\Entity\GFile\UploadFile',
            'csrf_protection'   => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'upload_gfilebundle_upload';
    }
}

