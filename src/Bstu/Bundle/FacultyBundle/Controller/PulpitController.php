<?php

namespace Bstu\Bundle\FacultyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\FacultyBundle\Entity\Pulpit;
use Bstu\Bundle\FacultyBundle\Form\PulpitType;

/**
 * Pulpit controller.
 *
 * @Route("/pulpit")
 */
class PulpitController extends Controller
{

    /**
     * Lists all Pulpit entities.
     *
     * @Route("/", name="pulpit")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BstuFacultyBundle:Pulpit')->createQueryBuilder('p');
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
     * Creates a new Pulpit entity.
     *
     * @Route("/", name="pulpit_create")
     * @Method("POST")
     * @Template("BstuFacultyBundle:Pulpit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pulpit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pulpit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Pulpit entity.
    *
    * @param Pulpit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Pulpit $entity)
    {
        $form = $this->createForm(new PulpitType(), $entity, array(
            'action' => $this->generateUrl('pulpit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Создать'));

        return $form;
    }

    /**
     * Displays a form to create a new Pulpit entity.
     *
     * @Route("/new", name="pulpit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pulpit();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pulpit entity.
     *
     * @Route("/{id}", name="pulpit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuFacultyBundle:Pulpit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pulpit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pulpit entity.
     *
     * @Route("/{id}/edit", name="pulpit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuFacultyBundle:Pulpit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pulpit entity.');
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
    * Creates a form to edit a Pulpit entity.
    *
    * @param Pulpit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pulpit $entity)
    {
        $form = $this->createForm(new PulpitType(), $entity, array(
            'action' => $this->generateUrl('pulpit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Обновить'));

        return $form;
    }
    /**
     * Edits an existing Pulpit entity.
     *
     * @Route("/{id}", name="pulpit_update")
     * @Method("PUT")
     * @Template("BstuFacultyBundle:Pulpit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuFacultyBundle:Pulpit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pulpit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pulpit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pulpit entity.
     *
     * @Route("/{id}", name="pulpit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BstuFacultyBundle:Pulpit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pulpit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pulpit'));
    }

    /**
     * Creates a form to delete a Pulpit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pulpit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
}
