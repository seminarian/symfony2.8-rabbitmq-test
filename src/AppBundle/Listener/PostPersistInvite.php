<?php

namespace AppBundle\Listener;

    use AppBundle\Entity\Banaan;
    use Doctrine\ORM\Event\LifecycleEventArgs;
    use Symfony\Component\DependencyInjection\Container;

    class PostPersistInvite
    {
        private $container;

        public function __construct(Container $container)
        {
            $this->container = $container;
        }

        public function postPersist(LifecycleEventArgs $args){
            $entity = $args->getEntity();
            if($entity instanceof Banaan) {
                $message = serialize(array('banaan_id' => $entity->getId()));
                $this->container->get('old_sound_rabbit_mq.add_mail_task_producer')
                                ->publish($message);
            }
        }
    }