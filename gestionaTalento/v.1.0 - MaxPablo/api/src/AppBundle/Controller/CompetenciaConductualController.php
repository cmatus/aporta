<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CompetenciaConductual;

class CompetenciaConductualController extends FOSRestController {
  /**
  * @Rest\Get("/competenciaConductual")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductual')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/competenciaConductual/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductual')->find($id);
     if ($singleresult === null) {
         return new View("CompetenciaConductual no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/competenciaConductual/nombre/{nombre}")
  */
 public function nombreAction($nombre) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductual')->findBy(array('nombre' => $nombre));
     if ($singleresult === null) {
         return new View("CompetenciaConductual no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

  /**
   * @Rest\Post("/competenciaConductual")
   */
  public function postAction(Request $request) {
      $data = new CompetenciaConductual;
      $nombre = $request->get('nombre');
      $definicion = $request->get('definicion');
      if (empty($nombre) || empty($definicion)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setNombre($nombre);
      $data->setDefinicion($definicion);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("CompetenciaConductual Agregado Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/competenciaConductual/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new CompetenciaConductual;
      $nombre = $request->get('nombre');
      $definicion = $request->get('definicion');
      $sn = $this->getDoctrine()->getManager();
      $competenciaConductual = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductual')->find($id);
      if (empty($competenciaConductual)) {
          return new View("competenciaConductual no encontrada", Response::HTTP_NOT_FOUND);
      } elseif (!empty($nombre) && !empty($definicion)) {
          $competenciaConductual->setNombre($nombre);
          $competenciaConductual->setDefinicion($definicion);
          $sn->flush();
          return new View("competenciaConductual Actualizado Correctamente", Response::HTTP_OK);
      } else
          return new View("Los datos nombre y definicion de  Competencia Conductual no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/competenciaConductual/{id}")
   */
  public function deleteAction($id) {
      $data = new CompetenciaConductual;
      $sn = $this->getDoctrine()->getManager();
      $competenciaConductual = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductual')->find($id);
      if (empty($competenciaConductual)) {
          return new View("No se encontro la CompetenciaConductual", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($competenciaConductual);
          $sn->flush();
      }
      return new View("CompetenciaConductual borrada Exitosamente!", Response::HTTP_OK);
  }
}
