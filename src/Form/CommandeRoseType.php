<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeRoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('classeFrom', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Dans quel classe êtes-vous ?',
                'placeholder' => '',
            ])
            ->add('classeTo', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Dans quel classe se trouve votre valentin.e ?',
                'placeholder' => '',
            ])
            ->add('msg', TextareaType::class,[
                'label' => 'Votre petit mot',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Commander',
            ])

        ;

        $fromFormModifier = function (FormInterface $form, Classe $classe = null) {
            $eleves = null === $classe ? [] : $classe->getEleves();

            $form->add('from', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => 'fullname',
                'label' => 'Qui passe la commande ?',
                'choices' => $eleves
            ]);
        };

        $toFromModifier = function (FormInterface $form, Classe $classe = null) {
            $eleves = null === $classe ? [] : $classe->getEleves();

            $form->add('to', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => 'fullname',
                'label' => 'Pour qui ?',
                'choices' => $eleves
            ]);
        };

        $builder->get('classeFrom')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($fromFormModifier) {
                $classe = $event->getForm()->getData();
                $fromFormModifier($event->getForm()->getParent(), $classe);
            }
        );

        $builder->get('classeTo')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($toFromModifier) {
                $classe = $event->getForm()->getData();
                $toFromModifier($event->getForm()->getParent(), $classe);
            }
        );

        // On postSetData create the form
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($fromFormModifier, $toFromModifier)
            {
                $form = $event->getForm();
                $classe = $event->getForm()->getData();

                $fromFormModifier($form, $classe);
                $toFromModifier($form, $classe);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
