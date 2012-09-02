<?php

namespace Hellspite\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hellspite\MediaBundle\Entity\Album;
use Hellspite\MediaBundle\Form\AlbumType;

/**
 * Album controller.
 *
 */
class AlbumController extends Controller
{
    /**
     * Lists all Album entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HellspiteMediaBundle:Album')->findAll();

        return $this->render('HellspiteMediaBundle:Album:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Album entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteMediaBundle:Album:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Album entity.
     *
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->createForm(new AlbumType(), $entity);

        return $this->render('HellspiteMediaBundle:Album:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Album entity.
     *
     */
    public function createAction()
    {
        $entity  = new Album();
        $request = $this->getRequest();
        $form    = $this->createForm(new AlbumType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_album_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HellspiteMediaBundle:Album:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm = $this->createForm(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteMediaBundle:Album:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Album entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm   = $this->createForm(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_album_edit', array('id' => $id)));
        }

        return $this->render('HellspiteMediaBundle:Album:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Album entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HellspiteMediaBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_album'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
