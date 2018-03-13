<?php


namespace App\Admin;


use App\Enum\EventTypeEnum;
use App\Enum\RankingTypeEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SportAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class);
        $formMapper->add('ranking_type', ChoiceType::class, [
            'choices' => [
                RankingTypeEnum::getLabel(RankingTypeEnum::TYPE_HIGHER_BETTER) => RankingTypeEnum::TYPE_HIGHER_BETTER,
                RankingTypeEnum::getLabel(RankingTypeEnum::TYPE_LOWER_BETTER) => RankingTypeEnum::TYPE_LOWER_BETTER,
            ],
        ]);
        $formMapper->add('event_type', ChoiceType::class, [
            'choices' => [
                EventTypeEnum::getLabel(EventTypeEnum::TYPE_1V1) => EventTypeEnum::TYPE_1V1,
                EventTypeEnum::getLabel(EventTypeEnum::TYPE_PLACEMENT) => EventTypeEnum::TYPE_PLACEMENT,
            ],
        ]);
        $formMapper->add('icon', TextType::class, [
            'sonata_help' => 'Find an appropriate icon <a href="https://raw.githubusercontent.com/jamesadevine/sportsfont/master/font.png">here</a> and type in the identifier next to it. (Ex. icon-soccer)',
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }
}