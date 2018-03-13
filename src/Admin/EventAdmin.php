<?php


namespace App\Admin;


use App\Form\ScoreType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name');
        $formMapper->add('startTime');
        $formMapper->add('endTime');
        $formMapper->add('group');
        $formMapper->add('location');
        $formMapper->add('competitor1');
        $formMapper->add('competitor2');
        $formMapper->add('scores', CollectionType::class, [
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'entry_type' => ScoreType::class,
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('group');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('group');
        $listMapper->addIdentifier('name');
        $listMapper->add('startTime');
        $listMapper->add('endTime');
        $listMapper->add('location');
    }

    public function prePersist($object)
    {
        foreach ($object->getScores() as &$score) {
            $score->setCollege(new College());
            $score->setEvent($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getScores() as &$score) {
            $score->setEvent($object);
        }
    }


}