<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reserva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reserva controller.
 *
 * @Route("user/reserva")
 */
class ReservaController extends Controller
{
    /**
     * Lists all reserva entities.
     *
     * @Route("/", name="user_reserva_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservas = $em->getRepository('AppBundle:Reserva')->findAll();

        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
        ));
    }

    /**
     * Creates a new reserva entity.
     *
     * @Route("/new", name="user_reserva_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reserva = new Reserva();
        $form = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush($reserva);

            return $this->redirectToRoute('user_reserva_show', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/new.html.twig', array(
            'reserva' => $reserva,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reserva entity.
     *
     * @Route("/{id}", name="user_reserva_show")
     * @Method("GET")
     */
    public function showAction(Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);

        return $this->render('reserva/show.html.twig', array(
            'reserva' => $reserva,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reserva entity.
     *
     * @Route("/{id}/edit", name="user_reserva_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);
        $editForm = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_reserva_edit', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/edit.html.twig', array(
            'reserva' => $reserva,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reserva entity.
     *
     * @Route("/{id}", name="user_reserva_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reserva $reserva)
    {
        $form = $this->createDeleteForm($reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reserva);
            $em->flush($reserva);
        }

        return $this->redirectToRoute('user_reserva_index');
    }

    /**
     * Creates a form to delete a reserva entity.
     *
     * @param Reserva $reserva The reserva entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reserva $reserva)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_reserva_delete', array('id' => $reserva->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * Creates a new opcion entity.
     *
     * @Route("/new/", name="user_reserva_turno")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function reservaturno(Request $request){
        $fecha = $request->get('fecha');
        $idopcion=$request->get('idopcion');
        $hora=$request->get('hora');
        $nombreopcion=$request->get('nombreopcion');
        $nombrenegocio=$request->get('nombrenegocio');

        $userid = $this->getUser()->getId();
        $username = $this->getUser()->getUsername();


//
//        echo $userid;
//        echo '//////';
//        echo $fecha;
//        echo '//////';
//        echo $idopcion;
//        echo '//////';
//        echo $hora;
//        echo '//////';
//        echo $username;
//        echo '//////';
//        
        
        return $this->render(':default:test.html.twig', array(
            'user' => $userid,
            'fecha' => $fecha,
            'idopcion' => $idopcion,
            'hora' => $hora,
            'username'=>$username,
            'nombreopcion'=>$nombreopcion,
            'nombrenegocio'=>$nombrenegocio

        ));
//
//        $Reserva = new Reserva();
//        $form = $this->createForm('AppBundle\Form\ReservaType', $Reserva);
//        $em = $this->getDoctrine()->getManager();
//
//
//        $Reserva->setUser($user);
//        $Reserva->setResFecha($fecha);
//        $Reserva->setOpcion($idopcion);
//        $Reserva->setResHora($hora);
//
//        $em->persist($Reserva);
//
//        $flush = $em->flush();
//
//        if ($flush == null) {
//            echo "Post creado correctamente";
//        } else {
//            echo "El post no se ha creado";
//        }





    }

    /**
     * Creates a new opcion entity.
     *
     * @Route("/misturnos/", name="misturnos")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function misturnos()

    {
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $turnos = $em->getRepository('AppBundle:Reserva')->findByuser($userid);

//        $h=$turnos->getopcion(1);
//        var_dump($h);
//        exit();

        return $this->render('default/misturnos.html.twig', array(
            'turnos' => $turnos,
        ));
    }
    
}
