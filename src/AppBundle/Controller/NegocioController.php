<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Negocio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Negocio controller.
 *
 * @Route("pers/negocio")
 */
class NegocioController extends Controller
{
    /**
     * Lists all negocio entities.
     *
     * @Route("/", name="pers_negocio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $negocios = $em->getRepository('AppBundle:Negocio')->findAll();

        return $this->render('negocio/index.html.twig', array(
            'negocios' => $negocios,
        ));
    }

    /**
     * Creates a new negocio entity.
     *
     * @Route("/new", name="pers_negocio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $negocio = new Negocio();
        $form = $this->createForm('AppBundle\Form\NegocioType', $negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($negocio);
            $em->flush($negocio);

            return $this->redirectToRoute('pers_negocio_show', array('id' => $negocio->getId()));
        }

        return $this->render('negocio/new.html.twig', array(
            'negocio' => $negocio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a negocio entity.
     *
     * @Route("/{id}", name="pers_negocio_show")
     * @Method("GET")
     */
    public function showAction(Negocio $negocio)
    {
        $deleteForm = $this->createDeleteForm($negocio);

        return $this->render('negocio/show.html.twig', array(
            'negocio' => $negocio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing negocio entity.
     *
     * @Route("/{id}/edit", name="pers_negocio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Negocio $negocio)
    {
        $deleteForm = $this->createDeleteForm($negocio);
        $editForm = $this->createForm('AppBundle\Form\NegocioType', $negocio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pers_negocio_edit', array('id' => $negocio->getId()));
        }

        return $this->render('negocio/edit.html.twig', array(
            'negocio' => $negocio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a negocio entity.
     *
     * @Route("/{id}", name="pers_negocio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Negocio $negocio)
    {
        $form = $this->createDeleteForm($negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($negocio);
            $em->flush($negocio);
        }

        return $this->redirectToRoute('pers_negocio_index');
    }

    /**
     * Creates a form to delete a negocio entity.
     *
     * @param Negocio $negocio The negocio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Negocio $negocio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pers_negocio_delete', array('id' => $negocio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
