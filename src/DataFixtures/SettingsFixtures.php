<?php

namespace App\DataFixtures;

use App\Entity\College;
use App\Entity\Sport;
use App\Enum\EventTypeEnum;
use App\Enum\RankingTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Colleges
        $college = new College();
        $college
            ->setName('FOI Varaždin')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FER Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('PMF Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('RITEH Rijeka')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FER Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('UNIRI Rijeka')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('PMF Split')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('TVZ Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FER Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FESB Split')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FER Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FERIT Osijek')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('FSB Zagreb')
            ->setCountry('HR');
        $manager->persist($college);
        $college = new College();
        $college
            ->setName('SFSB Slavonski Brod')
            ->setCountry('HR');
        $manager->persist($college);

        // Sports
        $sport = new Sport();
        $sport
            ->setName('Futsal')
            ->setIcon('icon-soccer')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Basketball')
            ->setIcon('icon-basketball-1')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Handball')
            ->setIcon('icon-handball')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Volleyball')
            ->setIcon('icon-volleyball')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Beach Volleyball')
            ->setIcon('icon-swimming')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Rowing')
            ->setIcon('icon-rowing')
            ->setEventType(EventTypeEnum::TYPE_PLACEMENT)
            ->setRankingType(RankingTypeEnum::TYPE_LOWER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Table Tennis')
            ->setIcon('icon-tabletennis')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Cross')
            ->setIcon('icon-run')
            ->setEventType(EventTypeEnum::TYPE_PLACEMENT)
            ->setRankingType(RankingTypeEnum::TYPE_LOWER_BETTER);
        $manager->persist($sport);
        $sport = new Sport();
        $sport
            ->setName('Chess')
            ->setIcon('icon-debate')
            ->setEventType(EventTypeEnum::TYPE_1V1)
            ->setRankingType(RankingTypeEnum::TYPE_HIGHER_BETTER);
        $manager->persist($sport);

        $manager->flush();
    }
}
