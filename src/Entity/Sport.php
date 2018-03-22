<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 */
class Sport
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
    private $name = '';

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $icon;

    /**
     * @ORM\Column(type="integer")
     */
    private $ranking_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $event_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="sport")
     */
    private $groups;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Sport
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Sport
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return Sport
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRankingType()
    {
        return $this->ranking_type;
    }

    /**
     * @param mixed $ranking_type
     * @return Sport
     */
    public function setRankingType($ranking_type)
    {
        $this->ranking_type = $ranking_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * @param mixed $event_type
     * @return Sport
     */
    public function setEventType($event_type)
    {
        $this->event_type = $event_type;
        return $this;
    }

    /**
     * @return Group
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->name;
    }

}
