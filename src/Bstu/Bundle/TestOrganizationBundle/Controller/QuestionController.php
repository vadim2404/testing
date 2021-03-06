<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\TestOrganizationBundle\Entity\Question;
use Bstu\Bundle\TestOrganizationBundle\Form\QuestionType;

/**
 * Question controller.
 *
 * @Route("/question")
 */
class QuestionController extends Controller
{

    /**
     * Lists all Question entities.
     *
     * @Route("/", name="question")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BstuTestOrganizationBundle:Question')->findByTeacher($this->getUser());
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
     * Creates a new Question entity.
     *
     * @Route("/{questionType}", name="question_create", requirements={"questionType" = "\d+"})
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Question:new.html.twig")
     */
    public function createAction(Request $request, $questionType)
    {
        $entity = (new Question())->setType(intval($questionType));
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            return $this->render('BstuTestOrganizationBundle:Question:form.html.twig', ['form' => $form->createView()]);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setTeacher($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('question_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Question entity.
    *
    * @param Question $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Question $entity)
    {
        $form = $this->createForm(new QuestionType($this->getUser()), $entity, array(
            'action' => $this->generateUrl('question_create', ['questionType' => $entity->getType()]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Создать'));

        return $form;
    }

    /**
     * Displays a form to create a new Question entity.
     *
     * @Route("/new/{questionType}", name="question_new", defaults={"questionType" = "1"}, requirements={"questionType" = "\d+"}, options={"expose" = true})
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request, $questionType)
    {
        $entity = (new Question())->setType(intval($questionType));
        $form   = $this->createCreateForm($entity)->createView();

        $templateParams = [
            'entity' => $entity,
            'form'   => $form,
        ];

        if (!$request->isXmlHttpRequest()) {
            return $templateParams;
        }

        return $this->render('BstuTestOrganizationBundle:Question:form.html.twig', $templateParams);
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/{id}", name="question_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Question')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     * @Route("/{id}/edit", name="question_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Question')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Question entity.');
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
    * Creates a form to edit a Question entity.
    *
    * @param Question $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Question $entity)
    {
        $form = $this->createForm(new QuestionType($this->getUser()), $entity, array(
            'action' => $this->generateUrl('question_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Обновить'))
            ->remove('type');

        return $form;
    }
    /**
     * Edits an existing Question entity.
     *
     * @Route("/{id}", name="question_update")
     * @Method("PUT")
     * @Template("BstuTestOrganizationBundle:Question:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuTestOrganizationBundle:Question')->find($id);

        if (!$entity || $entity->getTeacher() !== $this->getUser()) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('question_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Question entity.
     *
     * @Route("/{id}", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BstuTestOrganizationBundle:Question')->find($id);

            if (!$entity || $entity->getTeacher() !== $this->getUser()) {
                throw $this->createNotFoundException('Unable to find Question entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('question'));
    }

    /**
     * Creates a form to delete a Question entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
}
