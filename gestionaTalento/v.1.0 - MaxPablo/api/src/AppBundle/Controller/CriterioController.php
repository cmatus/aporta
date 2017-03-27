<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Criterio;

class CriterioController extends FOSRestController {
  /**
  * @Rest\Get("/criterio")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Criterio')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/criterio/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Criterio')->find($id);
     if ($singleresult === null) {
         return new View("criterio no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

  /**
   * @Rest\Post("/criterio")
   */
  public function postAction(Request $request) {
    //falta que puedra agregar y asignar la actividadClave_id
      $data = new Criterio;
      $nombre = $request->get('nombre');
      if (empty($nombre)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setNombre($nombre);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("Criterio Agregado Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/criterio/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new Criterio;
      $nombre = $request->get('nombre');
      $sn = $this->getDoctrine()->getManager();
      $criterio = $this->getDoctrine()->getRepository('AppBundle:Criterio')->find($id);
      if (empty($criterio)) {
          return new View("criterio not found", Response::HTTP_NOT_FOUND);
      } elseif (!empty($nombre)) {
          $criterio->setNombre($nombre);
          $sn->flush();
          return new View("criterio Actualizado Correctamente", Response::HTTP_OK);
      } else
          return new View("el nombre de CRITERIO no puede estar vacio!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/criterio/{id}")
   */
  public function deleteAction($id) {
      $data = new Criterio;
      $sn = $this->getDoctrine()->getManager();
      $criterio = $this->getDoctrine()->getRepository('AppBundle:Criterio')->find($id);
      if (empty($criterio)) {
          return new View("No se encontro la criterio", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($criterio);
          $sn->flush();
      }
      return new View("criterio borrado Exitosamente!", Response::HTTP_OK);
  }
}
