<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Negocio;
use AppBundle\Entity\Reserva;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;

class GeneneralController extends Controller
{
    /**
     * Creates a new opcion entity.
     *
     * @Route("/rubro/negocio/{rubroID}", name="general_rubro")
     * @Method({"GET", "POST"})
     *
     */
    public function negocios(Request $request)
    {
        $rubroID = $request->get('rubroID');
        $em = $this->getDoctrine()->getManager();
        $negocios = $em->getRepository('AppBundle:Negocio')->findByRubro($rubroID);


        return $this->render('default/negocios.html.twig', array(
            'negocios' => $negocios,
        ));
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();

        $rubros = $em->getRepository('AppBundle:Rubro')->findAll();


        return $this->render('default/index.html.twig', array(
            'rubros' => $rubros,
        ));
    }

    /**
     * Creates a new opcion entity.
     *
     * @Route("/negocio/comercio/{comercioID}", name="unico_comercio")
     * @Method({"GET", "POST"})
     *
     */
    public function comercio(Request $request)
    {
        $comercioID = $request->get('comercioID');


        $em = $this->getDoctrine()->getManager();
//        $negocios = $em->getRepository('AppBundle:Negocio')->findByRubro($rubroID);

        $recursos=$em->getRepository('AppBundle:Opcion')->findByopciones($comercioID);
        $negocios = $em->getRepository('AppBundle:Negocio')->find($comercioID);

//        var_dump($recursos);
//        exit();
        return $this->render('default/comercio.html.twig', array(
            'negocios' => $negocios,
            'recursos'=>$recursos,
        ));
    }


    /**
     * Displays a form to edit an existing Students entity.
     *
     * @Route("/buscador", name="seleccion_turno")
     * @Method({"GET", "POST"})
     */
    public function seleccionturno(Request $request)
    {


        $fecha = $request->request->get('fecha');
        $usuario = $request->request->get('recurso');

       

//        $usuario=$request->request->get('group1');


//        $negocioID=$request->request->get('negocioID');
//        $nombrenegocio=$request->request->get('nombrenegocio');

        //$fecha = $request->request->get('search');

        $dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
        $dia = $dias[date('N', strtotime($fecha))];

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();
        $nombreopcion=$em->getRepository('AppBundle:Opcion')->find($usuario);

        $nombre=$nombreopcion->getopcNombre('AppBundle:Opcion');



// HACEMOS LA PRIMERA QUERY PARA TRAER LAS HORAS QUE TRABAJA EN ESE DIA

        $query ="SELECT dis_inicio_am,dis_fin_am,dis_inicio_pm,dis_fin_pm FROM disponibilidad WHERE dis_dia='$dia' and id_opcion='$usuario'";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $horariosdetrabajo=$stmt->fetchAll();

// METEMOS EL ARREGLO EN UN ARREGLO MENOR

// ACA METEMOS TODOS LOS HORARIOS   DE INICIO A FIN
//        Hora inicial
        $inicioam=$horariosdetrabajo[0]['dis_inicio_am'];
//        Hora final
        $finam=$horariosdetrabajo[0]['dis_fin_am'];
//         Hora inicial tarde
        $iniciopm=$horariosdetrabajo[0]['dis_inicio_pm'];
//         Hora final tarde
        $finpm=$horariosdetrabajo[0]['dis_fin_pm'];

//------------------------------------------------------------------------------------
// HACEMOS LA SEGUNDA QUERY PARA TRAER LAS HORAS QUE ESTAN RESERVADOS
        //$fecha aca va fecha en ves de 2016-11-12
        $querya ="SELECT res_hora FROM reserva WHERE res_fecha='$fecha' and id_opcion='$usuario'";
        $stmta = $db->prepare($querya);
        $param = array();
        $stmta->execute($param);
        $horariosreservados=$stmta->fetchAll();
//        Horarios ocupados, como me los va a traer en arreglo seguro


        foreach ($horariosreservados as $hr){
            foreach ($hr as $valor){
                $ho[]=$valor;
            }
        }
//       ----------------------------------------------------------------------

// QUERY QUE ME TRAE CUANTO DURA CADA OPCION. #CRACKS #PROGRAMACION #2016
        $query ="SELECT opc_Tiempoturno FROM opcion WHERE id='$usuario'  ";
        $stmt = $db->prepare($query);
        $param = array();
        $stmt->execute($param);
        $duracion=$stmt->fetchAll();
//        var_dump($duracion);
//        Tiempo de trabajo
        $tiempoturno=$duracion[0]['opc_Tiempoturno'];


//--------------
//-----------------------------------------------------------------------------------------------------------



//-----------------------------------------------------------------------------------------------------------
// ACA HACE LA MAGIA Y SUMA LAS HORAS DESDE X HASTA Y. EN ESTE CASO LO HACE PARA LA MANIANA
        $horariosmaniana=array();
        $foo = (float) $finam;
        $f = (float) $inicioam;

        for ($i=1; $f<$foo; $i++) {
            $f = (float) $inicioam;
            $horariosmaniana[$i]=$inicioam;
            list($hr1,$m1)=split('[:]', $tiempoturno);
            list($hr2,$m2)=split('[:]', $inicioam);
            $inicioam=date("H:i:00",mktime($tiempoturno+$inicioam,$m1+$m2));
        }



//-----------------------------------------------------------------------------------------------------------
// ACA HACE LA MAGIA Y SUMA LAS HORAS DESDE X HASTA Y. EN ESTE CASO LO HACE PARA LA MANIANA

        $horatarde=array();
        for ($i = 1; $iniciopm < $finpm; $i++) {
            $horatarde[$i] = $iniciopm;
            list($hr1, $m1) = split('[:]', $tiempoturno);
            list($hr2, $m2) = split('[:]', $iniciopm);
            $iniciopm = date("H:i:00", mktime($tiempoturno + $iniciopm, $m1 + $m2));
        }

//-----------------------------------------------------------------------------------------------------------
//     ACA RESTO LOS 2 HORARIOS PARA MOSTRAR AL USUARIO
        $horariosmaniana = array_diff($horariosmaniana, $ho);
        $horatarde = array_diff($horatarde, $ho);


//-----------------------------------------------------------------------------------------------------------
//        echo "HORARIOS QUE VA A VER EL USUARIO";
//        $r[0]=$horariosmaniana;
//        $r[1]=$horatarde;
//        var_dump($r);
//        echo "HORARIOS YA RESERVADOS";
//
//        var_dump($ho);
//
//        echo "HORARIOS DESDE 08 HASTA 12";
//
//        var_dump($horariosmaniana);

//
//        return $this->render(':default:turnos.html.twig', array(
//            'maniana' => $horariosmaniana,
//            'tarde'=>$horatarde,
//            'nombrenegocio'=>$nombrenegocio,
//            'nombreopcion'=>$nombre,
//            'fecha'=>$fecha,
//            'idopcion'=>$usuario
//
//        ));

        return new JsonResponse($horariosmaniana);
    }

    /**
     * Displays a form to edit an existing Students entity.
     *
     * @Route("/andara", name="andara")
     * @Method({"GET", "POST"})
     */
    public function seleccion(Request $request)
    {

        $fecha = $request->request->get('fecha');
        $usuario = $request->request->get('recurso');

        $h = array('horas'=>array('08:00', '09:00', '10:00', '11:00', '12:00'));
        return new JsonResponse($h);

    }
}
