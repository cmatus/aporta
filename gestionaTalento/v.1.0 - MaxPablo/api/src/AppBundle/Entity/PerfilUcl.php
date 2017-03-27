<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerfilUcl
 *
 * @ORM\Table(name="perfilUCL")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerfilUclRepository")
 */
class PerfilUcl
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ucl_id", type="integer")
     */
    private $uclId;

    /**
     * @var int
     *
     * @ORM\Column(name="perfil_id", type="integer")
     */
    private $perfilId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uclId
     *
     * @param integer $uclId
     *
     * @return PerfilUcl
     */
    public function setUclId($uclId)
    {
        $this->uclId = $uclId;

        return $this;
    }

    /**
     * Get uclId
     *
     * @return int
     */
    public function getUclId()
    {
        return $this->uclId;
    }

    /**
     * Set perfilId
     *
     * @param integer $perfilId
     *
     * @return PerfilUcl
     */
    public function setPerfilId($perfilId)
    {
        $this->perfilId = $perfilId;

        return $this;
    }

    /**
     * Get perfilId
     *
     * @return int
     */
    public function getPerfilId()
    {
        return $this->perfilId;
    }
}
