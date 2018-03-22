<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreRepository")
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="scores")
     * @var Event
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\College", fetch="EAGER")
     * @var College
     */
    private $college;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $score;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $teamName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Score
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return Score
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return College
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @param College $college
     * @return Score
     */
    public function setCollege(College $college)
    {
        $this->college = $college;
        return $this;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param float $score
     * @return Score
     */
    public function setScore(float $score)
    {
        $this->score = $score;
        return $this;
    }

    public function __toString()
    {
        return $this->getCollege()->getName() . ' - ' . $this->getScore();
    }
}
