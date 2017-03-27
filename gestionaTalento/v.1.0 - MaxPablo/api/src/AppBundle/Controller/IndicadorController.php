<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Indicador;

class IndicadorController extends FOSRestController {
  /**
  * @Rest\Get("/indicador")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Indicador')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/indicador/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Indicador')->find($id);
     if ($singleresult === null) {
         return new View("indicador no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

  /**
   * @Rest\Post("/indicador")
   */
  public function postAction(Request $request) {
    //falta que puedra agregar y asignar la actividadClave_id
      $data = new Indicador;
      $nombre = $request->get('nombre');
      if (empty($nombre)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setNombre($nombre);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("Indicador Agregado Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/indicador/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new Indicador;
      $nombre = $request->get('nombre');
      $sn = $this->getDoctrine()->getManager();
      $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicador')->find($id);
      if (empty($indicador)) {
          return new View("indicador no encontrado", Response::HTTP_NOT_FOUND);
      } elseif (!empty($nombre)) {
          $indicador->setNombre($nombre);
          $sn->flush();
          return new View("indicador Actualizado Correctamente", Response::HTTP_OK);
      } else
          return new View("el nombre de Indicador no puede estar vacio!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/indicador/{id}")
   */
  public function deleteAction($id) {
      $data = new Indicador;
      $sn = $this->getDoctrine()->getManager();
      $indicador = $this->getDoctrine()->getRepository('AppBundle:Indicador')->find($id);
      if (empty($indicador)) {
          return new View("No se encontro el indicador", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($indicador);
          $sn->flush();
      }
      return new View("indicador borrado Exitosamente!", Response::HTTP_OK);
  }
}
