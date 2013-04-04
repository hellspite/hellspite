<?php

namespace Hellspite\AnnounceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hellspite\AnnounceBundle\Entity\Post;
use Hellspite\AnnounceBundle\Form\PostType;
use Hellspite\AnnounceBundle\Entity\PostTranslation;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('HellspiteAnnounceBundle:Post')->getLatest(null);

        $dql = "SELECT p FROM HellspiteAnnounceBundle:Post p";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('HellspiteAnnounceBundle:Post:index.html.twig', array(
            //'entities' => $entities,
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteAnnounceBundle:Post:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Post entity.
     *
     */
    public function newAction()
    {
        $entity = new Post();
        $form   = $this->createForm(new PostType(), $entity);

        return $this->render('HellspiteAnnounceBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Post entity.
     *
     */
    public function createAction()
    {
        $entity  = new Post();
        $request = $this->getRequest();
        $form    = $this->createForm(new PostType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity->setTitle($entity->getTitleEn());
            $entity->setText($entity->getTextEn());

            $entity->addTranslation(new PostTranslation('it', 'title', $entity->getTitleIt()));
            $entity->addTranslation(new PostTranslation('it', 'text', $entity->getTextIt()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $entity->setTitle($entity->getTitleIt());
            $entity->setText($entity->getTextIt());
            $entity->setTranslatableLocale('it');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_post_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HellspiteAnnounceBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $entity->setTitleEn($entity->getTitle());
        $entity->setTextEn($entity->getText());

        $translations = $entity->getTranslations();
        $entity->setTitleIt($translations->get(0)->getContent());
        $entity->setTextIt($translations->get(1)->getContent());


        $editForm = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteAnnounceBundle:Post:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Post entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm   = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $entity->setTitle($entity->getTitleEn());
            $entity->setText($entity->getTextEn());

            $translations = $entity->getTranslations();
            $translations[0]->update($entity->getTitleIt());
            $translations[1]->update($entity->getTextIt());

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $entity->setTitle($entity->getTitleIt());
            $entity->setText($entity->getTextIt());
            $entity->setTranslatableLocale('it');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_post_edit', array('id' => $id)));
        }

        return $this->render('HellspiteAnnounceBundle:Post:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_post'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function deleteIconAction($id){
    
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $entity->removeIcon();
        $entity->setIcon('');

        return $this->render('HellspiteAnnounceBundle:Post:icon.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
