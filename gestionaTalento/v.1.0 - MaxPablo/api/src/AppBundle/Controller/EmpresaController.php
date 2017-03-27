<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Persona;

class EmpresaController extends FOSRestController {

  /**
  * @Rest\Get("/empresa")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findAll();
     if ($restresult === null) {
       return new View("no hay Empresas agregadas", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/empresa/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($id);
     if ($singleresult === null) {
         return new View("empresa no encontrada", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/empresa/rut/{rut}")
  */
 public function rutAction($rut) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findBy(array('rut' => $rut));
     if ($singleresult === null) {
         return new View("empresa no encontrada", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/empresa/razonSocial/{razonSocial}")
  */
 public function razonSocialAction($razonSocial) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findBy(array('razonSocial' => $razonSocial));
     if ($singleresult === null) {
         return new View("empresa no encontrada", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Post("/empresa")
  */
 public function postAction(Request $request) {
     $data = new Empresa;
     $rut = $request->get('rut');
     $giro = $request->get('giro');
     $razonSocial = $request->get('razonSocial');
     $direccion = $request->get('direccion');
     $comuna = $request->get('comuna');
     $telefono = $request->get('telefono');
     if (empty($rut) || empty($giro) || empty($razonSocial) || empty($direccion) || empty($comuna) || empty($telefono)) {
         return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
     }
     $data->setRut($rut);
     $data->setGiro($giro);
     $data->setRazonSocial($razonSocial);
     $data->setDireccion($direccion);
     $data->setComuna($comuna);
     $data->setTelefono($telefono);
     $em = $this->getDoctrine()->getManager();
     $em->persist($data);
     $em->flush();
     return new View("empresa Agregada Correctamente", Response::HTTP_OK);
 }

//////////////////////////////////////////////////////////////////////////////////////
//falta la relacion para este metodo
/////////////////////////////////////////////////////////////////////////////////////
 /**
  * @Rest\Post("/empresa/{id}")
  */
 public function postAsignaAction($id, Request $request) {
    $data = new Empresa;
    $dataper = new Persona;
    $personaid = $request->get('personaId');
    $sn = $this->getDoctrine()->getManager();
    $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($id);
    if (empty($empresa)) {
        return new View(" not found", Response::HTTP_NOT_FOUND);
    }
    //$dataper->setPersonaId($personaid);
    $em = $this->getDoctrine()->getManager();
    $em->persist($data);
    $em->flush();
    return new View("empresa asiganada Correctamente", Response::HTTP_OK);
 }

 //se me ocurre crear otro controller para personaEmpresa mandandole los id de empresa y persona

 /**
 * @Rest\Put("/empresa/{id}")
 */
public function updateAction($id, Request $request) {
    $data = new Empresa;
    $rut = $request->get('rut');
    $giro = $request->get('giro');
    $razonSocial = $request->get('razonSocial');
    $direccion = $request->get('direccion');
    $comuna = $request->get('comuna');
    $telefono = $request->get('telefono');
    $sn = $this->getDoctrine()->getManager();
    $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($id);
    if (empty($empresa)) {
        return new View("empresa no encontrada", Response::HTTP_NOT_FOUND);
    } elseif (!empty($rut) && !empty($giro) && !empty($razonSocial) && !empty($direccion) && !empty($comuna) && !empty($telefono)) {
        $empresa->setRut($rut);
        $empresa->setGiro($giro);
        $empresa->setRazonSocial($razonSocial);
        $empresa->setDireccion($direccion);
        $empresa->setComuna($comuna);
        $empresa->setTelefono($telefono);
        $sn->flush();
        return new View("empresa Actualizada Correctamente", Response::HTTP_OK);
    } else
        return new View("Los datos rut, giro, razonSocial, direccion, comuna y telefono de empresa no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
}

 /**
  * @Rest\Delete("/empresa/{id}")
  */
 public function deleteAction($id) {
     $data = new Empresa;
     $sn = $this->getDoctrine()->getManager();
     $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($id);
     if (empty($empresa)) {
         return new View("No se encontro la empresa", Response::HTTP_NOT_FOUND);
     } else {
         $sn->remove($empresa);
         $sn->flush();
     }
     return new View("empresa borrada Exitosamente!", Response::HTTP_OK);
 }
}
