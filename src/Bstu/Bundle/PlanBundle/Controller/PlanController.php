<?php

namespace Bstu\Bundle\PlanBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Bstu\Bundle\PlanBundle\Entity\Plan;
use Bstu\Bundle\PlanBundle\Form\PlanType;
use Bstu\Bundle\TestOrganizationBundle\Entity\Test;

/**
 * Plan controller.
 *
 * @Route("/plan")
 */
class PlanController extends Controller
{

    /**
     * Lists all Plan entities.
     *
     * @Route("/", name="plan")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BstuPlanBundle:Plan')->findUnstartedPlans();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * List all Test entities.
     *
     * @Route("/test", name="plan_test")
     * @Method({"GET"})
     * @Template()
     */
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('BstuTestOrganizationBundle:Test')->findAll();

        return [
            'tests' => $tests,
        ];
    }

    /**
     * Creates a new Plan entity.
     *
     * @Route("/{testId}", name="plan_create", requirements={ "testId" = "\d+" })
     * @Method("POST")
     * @Template("BstuPlanBundle:Plan:new.html.twig")
     * @ParamConverter("test", class="BstuTestOrganizationBundle:Test", options={ "id" = "testId" })
     */
    public function createAction(Request $request, Test $test)
    {
        $entity = new Plan();
        $form = $this->createCreateForm($entity, $test);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setTest($test);
            $entity->setPlanedBy($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('plan_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'test'   => $test,
        );
    }

    /**
    * Creates a form to create a Plan entity.
    *
    * @param Plan $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Plan $entity, Test $test)
    {
        $form = $this->createForm(new PlanType(), $entity, array(
            'action' => $this->generateUrl('plan_create', ['testId' => $test->getId()]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Plan entity.
     *
     * @Route("/new/{testId}", name="plan_new", requirements={ "testId" = "\d+" })
     * @Method("GET")
     * @Template()
     * @ParamConverter("test", class="BstuTestOrganizationBundle:Test", options={ "id" = "testId" })
     */
    public function newAction(Test $test)
    {
        $entity = new Plan();
        $form   = $this->createCreateForm($entity, $test);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'test'   => $test,
        );
    }

    /**
     * Finds and displays a Plan entity.
     *
     * @Route("/{id}", name="plan_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuPlanBundle:Plan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Plan entity.
     *
     * @Route("/{id}/edit", name="plan_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuPlanBundle:Plan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plan entity.');
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
    * Creates a form to edit a Plan entity.
    *
    * @param Plan $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Plan $entity)
    {
        $form = $this->createForm(new PlanType(), $entity, array(
            'action' => $this->generateUrl('plan_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Plan entity.
     *
     * @Route("/{id}", name="plan_update")
     * @Method("PUT")
     * @Template("BstuPlanBundle:Plan:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BstuPlanBundle:Plan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('plan_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Plan entity.
     *
     * @Route("/{id}", name="plan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BstuPlanBundle:Plan')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Plan entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('plan'));
    }

    /**
     * Creates a form to delete a Plan entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
