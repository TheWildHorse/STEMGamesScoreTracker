<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ScorekeeperAuthenticationAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('group');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('group');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('code');
        $listMapper->add('group');
        $listMapper->add('link', 'html');
        $listMapper->add('QR', 'html');
    }

}