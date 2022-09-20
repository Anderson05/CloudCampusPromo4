<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\EntityListener\EntityListener;
use App\Event\ContactEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[Route('/contact')]
class ContactController extends AbstractController
{

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;


    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EventDispatcherInterface $evtDispatcher, LoggerInterface $loggerIf){
        $this->dispatcher = $evtDispatcher;
        $this->logger = $loggerIf;
    }

    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            // dd($this->dispatcher);
            $contactEvt = new ContactEvent($contact);
            $this->dispatcher->dispatch($contactEvt);

            $msg = sprintf("PROMO4-LOGGER : EVENT NEW CONTACT [%s - %s] ------- ", $contact->getName(), $contact->getEmail());
            // var_dump($msg);
            $this->logger->info($msg);
            // die;

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        // dd($contact);
        $contactEvt = new ContactEvent($contact);
        $this->dispatcher->dispatch($contactEvt);
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        $msg = sprintf("PROMO4-LOGGER : Edit EVENT NEW CONTACT [%s - %s] ------- ", $contact->getName(), $contact->getEmail());
        $this->logger->info($msg);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            // dd($this->dispatcher);
            $contactEvt = new ContactEvent($contact);
            $this->dispatcher->dispatch($contactEvt);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact, true);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
