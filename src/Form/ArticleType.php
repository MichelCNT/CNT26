<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//M*55pgs3*Y!K
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('shortTitle')
            ->add('Text')
            ->add('author')
            ->add('category', ChoiceType::class, [
                'choices' => $this->getChoices()

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    private function getChoices(): array
    {
        $choices = Article::CATEGORIES;
        $output = [];
        foreach ($choices as $k => $v)
            $output[$v] = $k;
        return $output;
    }
}
