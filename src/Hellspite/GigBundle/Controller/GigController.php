<?php

namespace Hellspite\GigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hellspite\GigBundle\Entity\Gig;
use Hellspite\GigBundle\Form\GigType;

/**
 * Gig controller.
 *
 */
class GigController extends Controller
{
    /**
     * Lists all Gig entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        //$entities = $em->getRepository('HellspiteGigBundle:Gig')->findAll();

        $dql = "SELECT g FROM HellspiteGigBundle:Gig g";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('HellspiteGigBundle:Gig:index.html.twig', array(
            //'entities' => $entities
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a Gig entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteGigBundle:Gig')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gig entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteGigBundle:Gig:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Gig entity.
     *
     */
    public function newAction()
    {
        $entity = new Gig();
        $form   = $this->createForm(new GigType(), $entity);

        return $this->render('HellspiteGigBundle:Gig:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Gig entity.
     *
     */
    public function createAction()
    {
        $entity  = new Gig();
        $request = $this->getRequest();
        $form    = $this->createForm(new GigType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gig_show', array('id' => $entity->getId())));
            
        }

        return $this->render('HellspiteGigBundle:Gig:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Gig entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteGigBundle:Gig')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gig entity.');
        }

        $editForm = $this->createForm(new GigType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HellspiteGigBundle:Gig:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Gig entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteGigBundle:Gig')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gig entity.');
        }

        $editForm   = $this->createForm(new GigType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gig_edit', array('id' => $id)));
        }

        return $this->render('HellspiteGigBundle:Gig:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gig entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('HellspiteGigBundle:Gig')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gig entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gig'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
