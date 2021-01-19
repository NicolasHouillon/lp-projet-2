<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    private Security $security;
    private $tokenStorage;

    /**
     * CommentType constructor.
     * @param Security $security
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(Security $security, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUser')
            ->add('idSujet')
            ->add('content')
            ->add('id_question')
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }

    public function onPreSetData(FormEvent $event)
    {
        $request = Request::createFromGlobals();
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity Comment */
        $entity = $event->getData(); //récupération de l'entité

        $form->remove('idUser');
        $form->remove('idSujet');
        $form->remove('id_question');

        $entity->setIdUser($this->tokenStorage->getToken()->getUser());
    }
}
