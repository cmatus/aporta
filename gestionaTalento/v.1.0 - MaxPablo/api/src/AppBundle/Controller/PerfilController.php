<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Perfil;

class PerfilController extends FOSRestController {

  /**
  * @Rest\Get("/perfil")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Perfil')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/perfil/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Perfil')->find($id);
     if ($singleresult === null) {
         return new View("perfil no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/perfil/nombre/{nombre}")
  */
 public function nombreAction($nombre) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Perfil')->findBy(array('nombre' => $nombre));
     if ($singleresult === null) {
         return new View("perfil no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/perfil/reporta/{reporta}")
  */
 public function reportaAction($reporta) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Perfil')->findBy(array('reporta' => $reporta));
     if ($singleresult === null) {
         return new View("perfil no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Post("/perfil")
  */
 public function postAction(Request $request) {
     $data = new Perfil;
     $nombre = $request->get('nombre');
     $objetivo = $request->get('objetivo');
     $reporta = $request->get('reporta');
     $tareas = $request->get('tareas');
     if (empty($nombre) || empty($objetivo) || empty($reporta) || empty($tareas)) {
         return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
     }
     $data->setNombre($nombre);
     $data->setObjetivo($objetivo);
     $data->setReporta($reporta);
     $data->setTareas($tareas);
     $em = $this->getDoctrine()->getManager();
     $em->persist($data);
     $em->flush();
     return new View("prefil Agregado Correctamente", Response::HTTP_OK);
 }

 /**
  * @Rest\Put("/perfil/{id}")
  */
 public function updateAction($id, Request $request) {
     $data = new Perfil;
     $nombre = $request->get('nombre');
     $objetivo = $request->get('objetivo');
     $reporta = $request->get('reporta');
     $tareas = $request->get('tareas');
     $sn = $this->getDoctrine()->getManager();
     $perfil = $this->getDoctrine()->getRepository('AppBundle:Perfil')->find($id);
     if (empty($perfil)) {
         return new View("perfil not found", Response::HTTP_NOT_FOUND);
     } elseif (!empty($nombre) && !empty($objetivo) && !empty($reporta) && !empty($tareas)) {
         $perfil->setNombre($nombre);
         $perfil->setObjetivo($objetivo);
         $perfil->setReporta($reporta);
         $perfil->setTareas($tareas);
         $sn->flush();
         return new View("perfil Actualizado Correctamente", Response::HTTP_OK);
     } else
         return new View("Los datos nombre, objetivo, reporta y tareas de Perfil no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
 }

 /**
  * @Rest\Delete("/perfil/{id}")
  */
 public function deleteAction($id) {
     $data = new Perfil;
     $sn = $this->getDoctrine()->getManager();
     $perfil = $this->getDoctrine()->getRepository('AppBundle:Perfil')->find($id);
     if (empty($perfil)) {
         return new View("No se encontro el perfil", Response::HTTP_NOT_FOUND);
     } else {
         $sn->remove($perfil);
         $sn->flush();
     }
     return new View("perfil borrado Exitosamente!", Response::HTTP_OK);
 }
}
