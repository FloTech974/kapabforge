<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la formation',
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => [
                    'maxlength' => 255,
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', NumberType::class, [
                'scale' => 2,
                'label' => 'Prix (en €)',
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée (en heures)',
            ])
            ->add('lessonCount', IntegerType::class, [
                'label' => 'Nombre de leçons',
            ])
            ->add('software', TextType::class, [
                'label' => 'Logiciels utilisés',
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publier la formation',
                'required' => false,
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Image de la formation',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une catégorie',
            ])
            ->add('level', EntityType::class, [
                'label' => 'Niveau',
                'class' => Level::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un niveau',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
