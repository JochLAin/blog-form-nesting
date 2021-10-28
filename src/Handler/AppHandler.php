<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class AppHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private KernelInterface $kernel,
        private LoggerInterface $logger,
        private SessionInterface $session,
    ) {
    }

    public function handle(FormInterface $form, array $memos)
    {
        try {
            $data = $form->getData();
            foreach ($data as $memo) {
                $this->em->persist($memo);
            }
            foreach ($memos as $memo) {
                if (!in_array($memo, $data)) {
                    $this->em->remove($memo);
                }
            }
            $this->em->flush();
            $this->session->getFlashBag()->add('success', 'Vos mémos ont été enregistrés en base.');
        } catch (\Throwable $exception) {
            $this->handleException($exception);
            $this->session->getFlashBag()->add('error', 'Oups! Il semble qu\'il se soit passé quelque chose durant l\'enregistrement.');
        }
    }

    protected function handleException(\Throwable $exception)
    {
        if (!$this->kernel->isDebug()) {
            $this->logger->error($exception->getFile().':'.$exception->getLine().' => '.$exception->getMessage());
        } else {
            throw $exception;
        }
    }
}
