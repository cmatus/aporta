<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\ActividadClave;

class ActividadClaveController extends FOSRestController {
  /**
  * @Rest\Get("/actividadClave")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:ActividadClave')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/actividadClave/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:ActividadClave')->find($id);
     if ($singleresult === null) {
         return new View("actividad clave no encontrada", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

  /**
   * @Rest\Post("/actividadClave")
   */
  public function postAction(Request $request) {
    //falta que puedra agregar y asignar la ucl_id
      $data = new ActividadClave;
      $nombre = $request->get('nombre');
      if (empty($nombre)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setNombre($nombre);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("ActividadClave Agregada Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/actividadClave/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new ActividadClave;
      $nombre = $request->get('nombre');
      $sn = $this->getDoctrine()->getManager();
      $actividadClave = $this->getDoctrine()->getRepository('AppBundle:ActividadClave')->find($id);
      if (empty($actividadClave)) {
          return new View("actividadClave not found", Response::HTTP_NOT_FOUND);
      } elseif (!empty($nombre)) {
          $actividadClave->setNombre($nombre);
          $sn->flush();
          return new View("actividadClave Actualizada Correctamente", Response::HTTP_OK);
      } else
          return new View("el nombre de la ACTIVIDAD CLAVE no puede estar vacio!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/actividadClave/{id}")
   */
  public function deleteAction($id) {
      $data = new ActividadClave;
      $sn = $this->getDoctrine()->getManager();
      $actividadClave = $this->getDoctrine()->getRepository('AppBundle:ActividadClave')->find($id);
      if (empty($actividadClave)) {
          return new View("No se encontro la ActividadClave", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($actividadClave);
          $sn->flush();
      }
      return new View("ActividadClave borrada Exitosamente!", Response::HTTP_OK);
  }
}
