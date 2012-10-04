<?php

namespace Hellspite\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hellspite\MediaBundle\Entity\Photo;
use Hellspite\MediaBundle\Form\PhotoType;
use Hellspite\MediaBundle\Entity\Album;

/**
 * Photo controller.
 *
 */
class PhotoController extends Controller
{
    public function addAction(){
        $photo = new Photo();
        $request = $this->getRequest();    
        $form = $this->createForm(new PhotoType(), $photo);
        $form->bindRequest($request);

        $album_id = $this->get('request')->request->get('album_num');
        $em = $this->getDoctrine()->getEntityManager();

        $album = $em->getRepository('HellspiteMediaBundle:Album')->find($album_id);

        if($form->isValid()){
            $photo->setAlbum($album);
            $em->persist($photo);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_album_edit', array('id' => $album_id)));
    }

    /**
     * Lists all Photo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HellspiteMediaBundle:Photo')->findAll();

        return $this->render('HellspiteMediaBundle:Photo:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Photo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteMediaBundle:Photo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Photo entity.
     *
     */
    public function newAction()
    {
        $entity = new Photo();
        $form   = $this->createForm(new PhotoType(), $entity);

        return $this->render('HellspiteMediaBundle:Photo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Photo entity.
     *
     */
    public function createAction()
    {
        $entity  = new Photo();
        $request = $this->getRequest();
        $form    = $this->createForm(new PhotoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photo_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HellspiteMediaBundle:Photo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Photo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $editForm = $this->createForm(new PhotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteMediaBundle:Photo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Photo entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteMediaBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $editForm   = $this->createForm(new PhotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photo_edit', array('id' => $id)));
        }

        return $this->render('HellspiteMediaBundle:Photo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Photo entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HellspiteMediaBundle:Photo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Photo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_photo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
