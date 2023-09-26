<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\Validator\Constraints\File;

class ArticleAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fkposttype', EntityType::class, [
                'label' => "Type d'article",
                'class' => PostType::class,
                'choice_label' => function (PostType $postType) {
                    return $postType->getName(); 
                },
            ])
            ->add('title', TextType::class, [
                'label' => "Titre de l'article",
            ])
            ->add('subtitle', TextType::class, [
                'label' => "Sous-titre",
                'required' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu de l'article",
            ])
            ->add('visuals', FileType::class, [
                'label' => "Images/Vidéos",
                'required' => false,
                'data_class' => null,
                'multiple' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir des documents au formats : png, jpg ou avi',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Publier',
                // 'class' => Visual::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
