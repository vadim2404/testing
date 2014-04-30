<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\TestOrganizationBundle\Entity\Theme;
use Bstu\Bundle\TestOrganizationBundle\Form\ThemeType;

/**
 * Theme controller.
 *
 * @Route("/theme")
 */
class ThemeController extends Controller
{

    /**
     * Lists all Theme entities.
     *
     * @Route("/", name="theme")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BstuTestOrganizationBundle:Theme')->findAllByTeacher($this->getUser());

        $paginator  = $this->get('knp_paginator');
        
        $entities = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return [
            'entities' => $entities,
        ];
    }
    /**
     * Creates a new Theme entity.
     *
     * @Route("/", name="theme_create")
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Theme:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Theme();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('theme_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Theme entity.
    *
    * @param Theme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Theme $entity)
    {
        $form = $this->createForm(new ThemeType($this->getUser()), $entity, array(
            'action' => $this->generateUrl('theme_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Создать'));

        return $form;
    }

    /**
     * Displays a form to create a new Theme entity.
     *
     * @Route("/new", name="theme_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Theme();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Theme entity.
     *
     * @Route("/{id}", name="theme_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Theme')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Theme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Theme entity.
     *
     * @Route("/{id}/edit", name="theme_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Theme')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Theme entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Theme entity.
    *
    * @param Theme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Theme $entity)
    {
        $form = $this->createForm(new ThemeType($this->getUser()), $entity, array(
            'action' => $this->generateUrl('theme_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Обновить'));

        return $form;
    }
    /**
     * Edits an existing Theme entity.
     *
     * @Route("/{id}", name="theme_update")
     * @Method("PUT")
     * @Template("BstuTestOrganizationBundle:Theme:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Theme')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Theme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('theme_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Theme entity.
     *
     * @Route("/{id}", name="theme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BstuTestOrganizationBundle:Theme')->find($id);

            if (!$entity || $entity->getTeacher() !== $this->getUser()) {
                throw $this->createNotFoundException('Unable to find Theme entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('theme'));
    }

    /**
     * Creates a form to delete a Theme entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('theme_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
}
