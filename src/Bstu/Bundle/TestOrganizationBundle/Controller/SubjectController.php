<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Bstu\Bundle\TestOrganizationBundle\Entity\Subject;
use Bstu\Bundle\TestOrganizationBundle\Form\SubjectType;

/**
 * Subject controller.
 *
 * @Route("/subject")
 */
class SubjectController extends Controller
{

    /**
     * Lists all Subject entities.
     *
     * @Route("/", name="subject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $subjects = $this->getUser()->getSubjects();

        $paginator  = $this->get('knp_paginator');
        
        $entities = $paginator->paginate(
            $subjects,
            $request->query->get('page', 1),
            10
        );

        return [
            'entities' => $entities,
        ];
    }
    /**
     * Creates a new Subject entity.
     *
     * @Route("/", name="subject_create")
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Subject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Subject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setTeacher($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Subject entity.
    *
    * @param Subject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Subject $entity)
    {
        $form = $this->createForm(new SubjectType(), $entity, array(
            'action' => $this->generateUrl('subject_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Создать'));

        return $form;
    }

    /**
     * Displays a form to create a new Subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Subject();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Subject entity.
     *
     * @Route("/{id}", name="subject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Subject')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Subject entity.
     *
     * @Route("/{id}/edit", name="subject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Subject')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
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
    * Creates a form to edit a Subject entity.
    *
    * @param Subject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Subject $entity)
    {
        $form = $this->createForm(new SubjectType(), $entity, array(
            'action' => $this->generateUrl('subject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Обновить'));

        return $form;
    }
    /**
     * Edits an existing Subject entity.
     *
     * @Route("/{id}", name="subject_update")
     * @Method("PUT")
     * @Template("BstuTestOrganizationBundle:Subject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Subject')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('subject_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Subject entity.
     *
     * @Route("/{id}", name="subject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BstuTestOrganizationBundle:Subject')->find($id);

            if (!$entity || $entity->getTeacher() !== $this->getUser()) {
                throw $this->createNotFoundException('Unable to find Subject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subject'));
    }

    /**
     * Creates a form to delete a Subject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
    
    /**
     * Ajax method. Get themes by subjects
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Subject $subject
     * @Route("/{id}/themes", name="subject_themes", options={"expose" = true})
     * @Method({"GET"})
     * @ParamConverter("subject", class="BstuTestOrganizationBundle:Subject")
     */
    public function themesAction(Request $request, Subject $subject)
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }
        $selected = new ArrayCollection();
        if ($testId = $request->query->getInt('test')) {
            $test = $this->getDoctrine()->getManager()->getRepository('BstuTestOrganizationBundle:Test')->find($testId);
            if ($test) {
                $selected = $test->getThemes();
            }
        }
        $themes = $subject->getThemes();
        $json = [];
        $fields = ['id', 'name'];
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($themes as $theme) {
            $entity = [];
            foreach ($fields as $field) {
                $entity[$field] = $accessor->getValue($theme, $field);
            }
            $entity['selected'] = $selected->contains($theme);
            $json[] = $entity;
        }
        return new JsonResponse($json);
    }
}
