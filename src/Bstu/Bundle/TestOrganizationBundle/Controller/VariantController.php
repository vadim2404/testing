<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\TestOrganizationBundle\Entity\Test;
use Bstu\Bundle\TestOrganizationBundle\Entity\Variant;
use Bstu\Bundle\TestOrganizationBundle\Form\VariantType;

/**
 * Variant controller.
 *
 * @Route("/variant")
 */
class VariantController extends Controller
{
    /**
     * Check test
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Test                  $test
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function checkTest(Test $test)
    {
        if ($test->getTeacher() !== $this->getUser()) {
            throw new AccessDeniedException('This test is not created by you');
        }

        if (Test::TYPE_VARIANT !== $test->getType()) {
            throw new AccessDeniedException('This functionality is available only for test with variants');
        }
    }

    /**
     * Lists all Variant entities.
     *
     * @Route("/{id}", name="variant")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Test $test)
    {
        $this->checkTest($test);

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BstuTestOrganizationBundle:Variant')->findByTest($test);

        return [
            'entities' => $entities,
            'test' => $test,
        ];
    }

    /**
     * Creates a new Variant entity.
     *
     * @Route("/{id}", name="variant_create")
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Variant:new.html.twig")
     */
    public function createAction(Request $request, Test $test)
    {
        $this->checkTest($test);

        $entity = (new Variant())->setTest($test);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('variant_show', array('id' => $entity->getId())));
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
            'test'   => $test,
        ];
    }

    /**
    * Creates a form to create a Variant entity.
    *
    * @param Variant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Variant $entity)
    {
        $form = $this->createForm(new VariantType(), $entity, array(
            'action' => $this->generateUrl('variant_create', [
                'id' => $entity->getTest()->getId(),
            ]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Создать'));

        return $form;
    }

    /**
     * Displays a form to create a new Variant entity.
     *
     * @Route("/new/{id}", name="variant_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Test $test)
    {
        $this->checkTest($test);

        $entity = (new Variant())->setTest($test);
        $form   = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
            'test'   => $test,
        ];
    }

    /**
     * Finds and displays a Variant entity.
     *
     * @Route("/{id}/show", name="variant_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Variant $variant)
    {
        $this->checkTest($variant->getTest());

        $deleteForm = $this->createDeleteForm($variant->getId());

        return [
            'entity'      => $variant,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Variant entity.
     *
     * @Route("/{id}/edit", name="variant_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Variant $variant)
    {
        $this->checkTest($variant->getTest());

        $editForm = $this->createEditForm($variant);
        $deleteForm = $this->createDeleteForm($variant->getId());

        return [
            'entity'      => $variant,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
    * Creates a form to edit a Variant entity.
    *
    * @param Variant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Variant $entity)
    {
        $form = $this->createForm(new VariantType(), $entity, array(
            'action' => $this->generateUrl('variant_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', ['label' => 'Обновить']);

        return $form;
    }

    /**
     * Edits an existing Variant entity.
     *
     * @Route("/{id}", name="variant_update")
     * @Method("PUT")
     * @Template("BstuTestOrganizationBundle:Variant:edit.html.twig")
     */
    public function updateAction(Request $request, Variant $variant)
    {
        $em = $this->getDoctrine()->getManager();

        $this->checkTest($variant->getTest());

        $deleteForm = $this->createDeleteForm($variant->getId());
        $editForm = $this->createEditForm($variant);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('variant_edit', ['id' => $variant->getId()]));
        }

        return [
            'entity'      => $variant,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Variant entity.
     *
     * @Route("/{id}", name="variant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Variant $variant)
    {
        $this->checkTest($test = $variant->getTest());

        $form = $this->createDeleteForm($variant->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($variant);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('variant', ['id' => $test->getId()]));
    }

    /**
     * Creates a form to delete a Variant entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('variant_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Удалить'])
            ->getForm()
        ;
    }
}
