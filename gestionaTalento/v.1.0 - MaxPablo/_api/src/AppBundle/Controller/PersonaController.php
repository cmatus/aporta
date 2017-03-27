<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Persona;
//use Symfony\Component\Security\Core\User\User;

class PersonaController extends FOSRestController {

    /**
     * @Rest\Get("/persona")
     */
    public function getAction() {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->findAll();
        if ($restresult === null) {
            return new View("Ninguna Persona fue Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/persona/{id}")
     */
    public function idAction($id) {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->find($id);
        if ($singleresult === null) {
            return new View("Persona no Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("/persona/rut/{rut}")
     */
    public function rutAction($rut) {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->findBy(array('rut' => $rut));
        if ($singleresult === null) {
            return new View("Persona no Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("/persona/nombre/{nombre}")
     */
    public function nombreAction($nombre) {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->findBy(array('nombre' => $nombre));
        if ($singleresult === null) {
            return new View("Persona no Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("/persona/apellidoPaterno/{apellidoPaterno}")
     */
    public function paternoAction($apellidoPaterno) {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->findBy(array('apellidoPaterno' => $apellidoPaterno));
        if ($singleresult === null) {
            return new View("Persona no Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("/persona/apellidoMaterno/{apellidoMaterno}")
     */
    public function maternoAction($apellidoMaterno) {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Persona')->findBy(array('apellidoMaterno' => $apellidoMaterno));
        if ($singleresult === null) {
            return new View("Persona no Encontrada!", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/persona")
     */
    public function postAction(Request $request) {
        $data = new Persona;
        $rut = $request->get('rut');
        $nombre = $request->get('nombre');
        $apellidoP = $request->get('apellidoPaterno');
        $apellidoM = $request->get('apellidoMaterno');
        $correo = $request->get('correo');
        $perfil = $request->get('perfilId');
        if (empty($rut) || empty($nombre) || empty($apellidoP) || empty($apellidoM) || empty($correo) || empty($perfil)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setRut($rut);
        $data->setNombre($nombre);
        $data->setApellidoPaterno($apellidoP);
        $data->setApellidoMaterno($apellidoM);
        $data->setCorreo($correo);
        $data->setPerfilId($perfil);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Persona Agregada Correctamente", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/persona/{id}")
     */
    public function updateAction($id, Request $request) {
        $data = new Persona;
        $rut = $request->get('rut');
        $nombre = $request->get('nombre');
        $apellidoP = $request->get('apellidoPaterno');
        $apellidoM = $request->get('apellidoMaterno');
        $correo = $request->get('correo');
        $perfil = $request->get('perfilId');
        $sn = $this->getDoctrine()->getManager();
        $persona = $this->getDoctrine()->getRepository('AppBundle:Persona')->find($id);
        if (empty($persona)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        } elseif (!empty($rut) && !empty($nombre) && !empty($correo) && !empty($perfil)) {
            $persona->setRut($rut);
            $persona->setNombre($nombre);
            $persona->setCorreo($correo);
            $persona->setPerfilId($perfil);
            $sn->flush();
            return new View("Persona Actualizada Correctamente", Response::HTTP_OK);
        } elseif (empty($rut) && empty($nombre) && empty($apellidoP) && empty($apellidoM) && empty($correo) && !empty($perfil)) {
            $persona->setPerfil($perfil);
            $sn->flush();
            return new View("Perfil Actualizado Correctamente", Response::HTTP_OK);
        } elseif (empty($rut) && empty($nombre) && empty($apellidoP) && empty($apellidoM)  && !empty($correo) && empty($perfil)) {
            $persona->setCorreo($correo);
            $sn->flush();
            return new View("Correo Actualizado Correctamente", Response::HTTP_OK);
        } elseif (empty($rut) && empty($nombre) && empty($apellidoP) && !empty($apellidoM)  && empty($correo) && empty($perfil)) {
            $persona->setApellidoMaterno($apellidoM);
            $sn->flush();
            return new View("Apellido Materno Actualizado Correctamente", Response::HTTP_OK);
        } elseif (empty($rut) && empty($nombre) && !empty($apellidoP) && empty($apellidoM)  && empty($correo) && empty($perfil)) {
            $persona->setApellidoPaterno($apellidoP);
            $sn->flush();
            return new View("Apellido Paterno Actualizado Correctamente", Response::HTTP_OK);
        } elseif (empty($rut) && !empty($nombre) && empty($correo) && empty($perfil)) {
            $persona->setNombre($nombre);
            $sn->flush();
            return new View("Nombre Actualizado Correctamente", Response::HTTP_OK);
        } elseif (!empty($rut) && empty($nombre) && empty($correo) && empty($perfil)) {
            $persona->setRut($rut);
            $sn->flush();
            return new View("Rut Actualizado Correctamente", Response::HTTP_OK);
        } else
            return new View("Los datos rut, nombre,apellido paterno, apellido paterno, correo y perfil de Persona no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Delete("/persona/{id}")
     */
    public function deleteAction($id) {
        $data = new Persona;
        $sn = $this->getDoctrine()->getManager();
        $persona = $this->getDoctrine()->getRepository('AppBundle:Persona')->find($id);
        if (empty($persona)) {
            return new View("No se encontro a la Persona", Response::HTTP_NOT_FOUND);
        } else {
            $sn->remove($persona);
            $sn->flush();
        }
        return new View("Persona borrada Exitosamente!", Response::HTTP_OK);
    }

}
