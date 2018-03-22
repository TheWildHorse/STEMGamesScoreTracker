<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $state = 1;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endTime;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="events")
     */
    protected $group;

    /**
     * @ORM\Column(type="text")
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Score", mappedBy="event", cascade={"persist"})
     * @ORM\OrderBy({"score" = "DESC"})
     */
    protected $scores;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\College", fetch="EAGER")
     */
    private $competitor1 = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\College", fetch="EAGER")
     */
    private $competitor2 = null;

    /**
     * @return mixed
     */
    public function getCompetitor1()
    {
        return $this->competitor1;
    }

    /**
     * @param mixed $competitor1
     * @return Event1v1
     */
    public function setCompetitor1($competitor1)
    {
        $this->competitor1 = $competitor1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompetitor2()
    {
        return $this->competitor2;
    }

    /**
     * @param mixed $competitor2
     * @return Event1v1
     */
    public function setCompetitor2($competitor2)
    {
        $this->competitor2 = $competitor2;
        return $this;
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
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     * @return Event
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     * @return Event
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
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
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Event
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Score[]
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param mixed $scores
     * @return Event
     */
    public function setScores($scores)
    {
        foreach($scores as &$score) {
            $score->setEvent($this);
        }
        $this->scores = $scores;
        return $this;
    }

    public function addScore(Score $score) {
        $score->setEvent($this);
        $this->scores[] = $score;
    }

    public function __toString()
    {
        if($this->getGroup() === null || $this->getGroup()->getSport() === null) {
            return 'New Event';
        }
        return $this->getGroup()->getSport()->getName() . ' -> ' . $this->getGroup()->getName() . ' -> ' . $this->getName();
    }

    /**
     * @param mixed $state
     * @return Event
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }


}
