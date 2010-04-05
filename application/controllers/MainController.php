<?php

class MainController extends Teleserv_Controller_Action_Secure
{
    protected $_allowedRoles = array();

    public function indexAction()
    {
    }

    public function navAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $nav = array();
        $nav[] = array(
            'text' => 'Administrator',
            'children' => array(
                array(
                    'text' => 'Users',
                    'leaf' => true,
                    'loadModule' => 'slots',
                    'loadTab' => 'App.slots.generate',
                ),

                array(
                    'text' => 'Group Roles',
                    'leaf' => true,
                    'loadModule' => 'slots',
                    'loadTab' => 'App.slots.view',
                ),
            )
        );

        $nav[] = array(
            'text' => 'Categories & Products',
            'children' => array(
                array(
                    'text' => 'Categories',
                    'leaf' => true,
                    'loadTab' => 'App.category.add',
                ),
                array(
                    'text' => 'Product List',
                    'leaf' => true,
                    'loadTab' => 'App.product.list',
                )
            )
        );

        $nav[] = array(
            'text' => 'Features',
            'children' => array(
                array(
                    'text' => 'List',
                    'leaf' => true,
                    'loadModule' => 'features',
                    'loadTab' => 'App.features.list',
                ),
                array(
                    'text' => 'Product Features',
                    'leaf' => true,
                    'loadModule' => 'features',
                    'loadTab' => 'App.features.member',
                )
            )
        );

        $nav[] = array(
            'text' => 'Specifications',
            'children' => array(
                array(
                    'text' => 'List',
                    'leaf' => true,
                    'loadModule' => 'specifications',
                    'loadTab' => 'App.specifications.list',
                ),
                array(
                    'text' => 'Product Specifications',
                    'leaf' => true,
                    'loadModule' => 'specifications',
                    'loadTab' => 'App.specifications.member',
                )
            )
        );

        $nav[] = array(
            'text' => 'Files',
            'children' => array(
                array(
                    'text' => 'Bios',
                    'leaf' => true,
                    'loadTab' => '',
                ),
                array(
                    'text' => 'Drivers',
                    'leaf' => true,
                    'loadTab' => '',
                ),
            )
        );

        echo json_encode($nav);
    }
}

