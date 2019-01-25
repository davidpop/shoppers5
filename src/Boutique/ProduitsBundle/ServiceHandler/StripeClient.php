<?php

namespace Boutique\ProduitsBundle\ServiceHandler ;

use Boutique\ProduitsBundle\Entity\Commande;
use Boutique\UserBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

    class StripeClient {
        private $config;
        private $em;
        private $logger;
        public function __construct($secretKey,
                                    array $config,
                                    EntityManagerInterface $em,
                                    LoggerInterface $logger)
        {
            \Stripe\Stripe::setApiKey($secretKey);
            $this->config = $config;
            $this->em = $em;
            $this->logger = $logger;
        }
        public function createPremiumCharge(Commande $commande, $token)
        {
            try {
                $charge = \Stripe\Charge::create([
                    'amount' => 100 * $commande->getMontant(),
                    'currency' => $this->config['currency'],
                    'description' => 'Paiement de la commande du '.date('Y-m-d H:i:s'),
                    'source' => $token,
                    'receipt_email' => $commande->getUser()->getEmail(),
                ]);
                $commande->setPaymentStatus(true);
//                dump($charge);
            } catch (\Stripe\Error\Base $e) {
                $commande->setPaymentStatus(false);
                $this->logger->error(sprintf('%s exception encountered when creating a premium payment: "%s"', get_class($e), $e->getMessage()), ['exception' => $e]);
                throw $e;
            }
            $commande->setChargeId($charge->id);
//            $user->setPremium($charge->paid);
            $this->em->flush();

        }
    }