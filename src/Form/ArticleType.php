<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu', TextareaType::class,['attr' => ['rows' => 15,]])
                
            ->add('img')
            ->add('idCategorie', EntityType::class,['class'=>Categorie::class, 'choice_label'=>'libelle_categorie', 'multiple' => true, 'expanded'=>true])
            //->add('slug')
            //->add('dateInscription')
            //->add('idUtilisateur')
            //->add('idCategorie')
            ->add('save', SubmitType::class, ['label' => 'Create Article'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
