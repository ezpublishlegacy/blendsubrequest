<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Class BlendSubRequestOperator
 */
class BlendSubRequestOperator
{
    /**
     * @var \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    private $kernel;

    function BlendSubRequestOperator()
    {
    }

    function operatorList()
    {
        return array( 'render_controller', 'render_url' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array(
            'render_controller' => array(
                'destination' => array(
                    'type' => 'string',
                    'require' => true,
                    'default' => ''
                ),
                'params' => array(
                    'type' => 'array',
                    'required' => true,
                    'default' => array()
                )
            ),
            'render_url' => array(
                'params' => array(
                    'type' => 'array',
                    'required' => true,
                    'default' => array()
                )
            ),
        );

    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        $destination = $namedParameters['destination'];
        $params = $namedParameters['params'];

        //$ezKernel = ezpKernel::instance();

        //echo "<pre>"; print_r($ezKernel); echo "</pre>";


        $container = ezpKernel::instance()->getServiceContainer();

        //echo "<pre>"; print_r($container); echo "</pre>";

        $fragmentHandler = $container->get('fragment.handler');

        $ref = new \Symfony\Component\HttpKernel\Controller\ControllerReference($destination, $params);

        try {
            $operatorValue = $fragmentHandler->render($ref);
        } catch ( Exception $e ) {
            $operatorValue = $e->getMessage();
        }

    }
}

?>