<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScorekeeperAuthenticationRepository")
 */
class ScorekeeperAuthentication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group")
     */
    private $group;


    public function __construct()
    {
        $this->setCode(str_replace('/', '', base64_encode(random_bytes(30))));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ScorekeeperAuthentication
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return ScorekeeperAuthentication
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     * @return ScorekeeperAuthentication
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    public function getDashboardURL() {
        return '/scorekeeper/'.$this->getCode();
    }

    public function getLink() {
        return '<a href="'.$this->getDashboardURL().'" target="_blank">Link to Scorekeeper Dashboard</a>';
    }

    public function getQR() {
        return '<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $this->getDashboardURL() . '"/>';
    }

}
