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

class EmpresaController extends FOSRestController {

  /**
  * @Rest\Get("/empresa")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findAll();
     if ($restresult === null) {
       return new View("no hay nada wetamaxi", Response::HTTP_NOT_FOUND);
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

 /**
 * @Rest\Put("/perfil/{id}")
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
        return new View("empresa not found", Response::HTTP_NOT_FOUND);
    } elseif (!empty($rut) && !empty($giro) && !empty($razonSocial) && !empty($direccion) && !empty($comuna) && !empty($telefono)) {
        $empresa->setNombre($rut);
        $empresa->setObjetivo($giro);
        $empresa->setReporta($razonSocial);
        $empresa->setTareas($direccion);
        $empresa->setReporta($comuna);
        $empresa->setTareas($telefono);
        $sn->flush();
        return new View("empresa Actualizada Correctamente", Response::HTTP_OK);
    } elseif (!empty($rut) && empty($giro) && empty($razonSocial) && empty($direccion) && empty($comuna) && empty($telefono)) {
        $empresa->setRut($rut);
        $sn->flush();
        return new View("rut Actualizado Correctamente", Response::HTTP_OK);
    } elseif (empty($rut) && !empty($giro) && empty($razonSocial) && empty($direccion) && empty($comuna) && empty($telefono)) {
        $empresa->setObjetivo($giro);
        $sn->flush();
        return new View("giro Actualizado Correctamente", Response::HTTP_OK);
    } elseif (empty($rut) && empty($giro) && !empty($razonSocial) && empty($direccion) && empty($comuna) && empty($telefono)) {
        $empresa->setReporta($razonSocial);
        $sn->flush();
        return new View("razon social Actualizada Correctamente", Response::HTTP_OK);
    } elseif (empty($rut) && empty($giro) && empty($razonSocial) && !empty($direccion) && empty($comuna) && empty($telefono)) {
        $empresa->setTareas($direccion);
        $sn->flush();
        return new View("direccion Actualizada Correctamente", Response::HTTP_OK);
    } elseif (empty($rut) && empty($giro) && empty($razonSocial) && empty($direccion) && !empty($comuna) && empty($telefono)) {
        $empresa->setReporta($comuna);
        $sn->flush();
        return new View("comuna Actualizada Correctamente", Response::HTTP_OK);
    } elseif (empty($rut) && empty($giro) && empty($razonSocial) && empty($direccion) && empty($comuna) && !empty($telefono)) {
        $empresa->setTareas($telefono);
        $sn->flush();
        return new View("Tareas Actualizadas Correctamente", Response::HTTP_OK);
    } else
        return new View("Los datos rut, giro, razonSocial, direccion, comuna y telefono de empresa no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
}

 /**
  * @Rest\Delete("/empresa/{id}")
  */
 public function deleteAction($id) {
     $data = new Empresa;
     $sn = $this->getDoctrine()->getManager();
     $perfil = $this->getDoctrine()->getRepository('AppBundle:Empresa')->find($id);
     if (empty($empresa)) {
         return new View("No se encontro la empresa", Response::HTTP_NOT_FOUND);
     } else {
         $sn->remove($empresa);
         $sn->flush();
     }
     return new View("empresa borrada Exitosamente!", Response::HTTP_OK);
 }
}
