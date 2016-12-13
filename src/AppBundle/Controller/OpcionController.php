<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Opcion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Opcion controller.
 *
 * @Route("pers/opcion")
 */
class OpcionController extends Controller
{
    /**
     * Lists all opcion entities.
     *
     * @Route("/", name="pers_opcion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $opcions = $em->getRepository('AppBundle:Opcion')->findAll();

        return $this->render('opcion/index.html.twig', array(
            'opcions' => $opcions,
        ));
    }

    /**
     * Creates a new opcion entity.
     *
     * @Route("/new/", name="pers_opcion_new")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function newAction(Request $request)
    {
        $negocioId = $request->get('idnegocio');
        $opcion = new Opcion();
        $form = $this->createForm('AppBundle\Form\OpcionType', $opcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($opcion);
            $em->flush($opcion);

            $opciones = $em->getRepository('AppBundle:Opcion')->findByopciones($negocioId );


            return $this->render('opcion/index.html.twig', array(
                'opcions' => $opciones,
                'negocioid'=>$negocioId,
            ));

//            return $this->redirectToRoute('pers_opcion_show', array('id' => $opcion->getId()));
        }

        $opcion =   $product = $this->getDoctrine()
            ->getRepository('AppBundle:Negocio')
            ->find($negocioId);



        $form->get('opciones')->setData($opcion);
        //var_dump($form);
        //exit();
        return $this->render('opcion/new.html.twig', array(
            'opcion' => $opcion,
            'form' => $form->createView(),

        ));
    }

    /**
     * Finds and displays a opcion entity.
     *
     * @Route("/{id}", name="pers_opcion_show")
     * @Method("GET")
     * @param Request $request Request
     * @return Response
     */
    public function showAction(Request $request,Opcion $opcion)
    {
        $negocioId = $request->get('idnegocio');

        $deleteForm = $this->createDeleteForm($opcion);

        return $this->render('opcion/show.html.twig', array(
            'opcion' => $opcion,
            'delete_form' => $deleteForm->createView(),
            'idnegocio'=>$negocioId,
            
        ));
    }

    /**
     * Displays a form to edit an existing opcion entity.
     *
     * @Route("/{id}/edit", name="pers_opcion_edit")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     */
    public function editAction(Request $request, Opcion $opcion)
    {
        $negocioId = $request->get('idnegocio');

        $deleteForm = $this->createDeleteForm($opcion);
        $editForm = $this->createForm('AppBundle\Form\OpcionType', $opcion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();

            $opciones = $em->getRepository('AppBundle:Opcion')->findByopciones($negocioId );


            return $this->render('opcion/index.html.twig', array(
                'opcions' => $opciones,
                'negocioid'=>$negocioId,
            ));

//            return $this->redirectToRoute('pers_opcion_edit', array('id' => $opcion->getId()));
        }

        return $this->render('opcion/edit.html.twig', array(
            'opcion' => $opcion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'idnegocio'=>$negocioId,

        ));
    }

    /**
     * Deletes a opcion entity.
     *
     * @Route("/{id}", name="pers_opcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Opcion $opcion)
    {
        $form = $this->createDeleteForm($opcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($opcion);
            $em->flush($opcion);
        }

        return $this->redirectToRoute('pers_opcion_index');
    }

    /**
     * Creates a form to delete a opcion entity.
     *
     * @param Opcion $opcion The opcion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Opcion $opcion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pers_opcion_delete', array('id' => $opcion->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

//    /**
//     * Creates a new opcion entity.
//     *
//     * @Route("/new/", name="general_rubro")
//     * @Method({"GET", "POST"})
//     * @param Request $request Request
//     * @return Response
//     *
//     */
//    public function indexActio(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $rubroID = $request->get('rubroID');
//
//        $opcions = $em->getRepository('AppBundle:Rubro')->find($rubroID);
//
//        return $this->render('default/index.html.twig', array(
//            'opcions' => $opcions,
//        ));
//    }
}
