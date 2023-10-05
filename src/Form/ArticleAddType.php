<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Visual;
use App\Entity\PostType;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('content', CKEditorType::class, [
                'config' => [
                    'toolbar' => 'full',
                    'required' => true,
                    'uiColor' => '#ffffff',
                ],'input_sync' => true,
                'label' => 'Contenu de l\'article',
            ])
            ->add('visuals', FileType::class, [
                'label' => "Images/Vidéos",
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                /* 'constraints' => [
                    'Assert\File'([
                            'extensions' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'video/x-msvideo',
                            ],
                        'extensionsMessage' => 'Merci de choisir des documents avec les extensions : pdf, png, jpg ou avi',
                        'uploadErrorMessage' => 'Une erreur s\'est produite lors du téléchargement du fichier.',
                    ])
                ], */
            ])

            ->add('Publier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
