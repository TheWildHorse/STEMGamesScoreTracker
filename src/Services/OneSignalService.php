<?php


namespace App\Services;


use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OneSignalService
{
    use ContainerAwareTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function sendMessage($message, $playersIds) {
        if(empty($playersIds)) {
            return;
        }
        $oneSignalComm = $this->container->get('eight_points_guzzle.client.one_signal');
        $oneSignalComm->post('notifications', [
            'json' => [
                'app_id' => '815fe3f0-04f8-4351-8077-fd7b9d369793',
                'include_player_ids' => $playersIds,
                'contents' => ['en' => $message]
            ]
        ]);
    }
}