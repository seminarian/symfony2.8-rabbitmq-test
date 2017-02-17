<?php

namespace AppBundle\Callback;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use AppBundle\Banaan;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\DependencyInjection\Container;

class MailTaskConsumer implements ConsumerInterface
{
    private $container;
    private $em;
    private $logger;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
        $this->logger = new Logger('mails_tasks');
//        $this->logger->pushHandler(new StreamHandler($container->parameters['mails_tasks_log']), Logger::WARNING);
    }

    public function execute(AMQPMessage $msg)
    {
        try {
//            $this->logger->addInfo('Start executing');
            $message = unserialize($msg->body);
            $id = $message['banaan_id'];
            echo "Verwerken gestart: id" . $id . "\n";
//            dump($inviteId);
            /* put your code here */
            sleep(10);
//            $pathInvite = $this->em->getRepository('APIBundle:PathInvite')->find($inviteId);
            //$this->container->get('api_mailer')->sendPrivatePathInvites($pathInvite);
            /* end your code */
//            $this->logger->addInfo('End executing');
            echo "Verwerken Geeindigd: id" . $id . " \n";
        }
        catch(\Exception $e){
            $this->logger->addError($e->getMessage());
        }
    }
}