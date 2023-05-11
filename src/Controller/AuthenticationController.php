<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\SetPasswordType;
use App\Form\UserType;
use App\Repository\RegisterHashRepository;
use App\Repository\UserRepository;
use App\Service\FormService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route("", name: "auth")]
class AuthenticationController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RegisterHashRepository $registerHashRepository,
        private readonly UserService $userService,
        private readonly FormService $formService
    )
    {
    }

    #[Route("/login", name: "Login")]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('list');
        }

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        $form->setData(['username' => $authenticationUtils->getLastUsername()]);

        return $this->render('templates/Authentication/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form
        ]);

    }

    #[Route('/logout', name: 'Logout')]
    public function logout(): Response
    {

        return $this->redirectToRoute('authLogin');
    }

    #[Route('/register/{hash}', name: 'Password')]
    public function setPassword(
        Request $request,
        UserPasswordHasherInterface $hasher,
        string $hash
    ): Response
    {
        $this->registerHashRepository->cleanHashes();

        if ($this->getUser()) {
            return $this->redirectToRoute('timesheet');
        }

        $registerHash = $this->registerHashRepository->findOneByHash($hash);
        $user = $registerHash?->getUser();
        if ($user === null) {
            return $this->render('templates/auth/setPasswordInvalidHash.html.twig');
        }

        $form = $this->createForm(SetPasswordType::class, null, ['email' => $user->getEmail()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $passwordHash = $hasher->hashPassword($user, $form->getData()['password']);

            $user->setPassword($passwordHash);
            $this->userRepository->save($user, true);
            $this->registerHashRepository->remove($registerHash);

            return $this->redirectToRoute('authLogin');
        }

        $errors = $form->getErrors(true);

        return $this->render('templates/auth/setPassword.html.twig', [
            'error' => $errors->count() > 0 ? $errors->offsetGet(0) : null,
            'form' => $form,
            'person' => $user
        ]);
    }


    #[Route('/resetPassword/{user}', name: 'ResetPassword')]
    public function resetPassword(User $user): Response
    {
        if (!$this->isGranted("ROLE_PM") && $user !== $this->getUser()) {
            return new Response('', 403);
        }

        $user->setPassword(null);
        $this->userService->createHashFor($user);
        $this->userRepository->save($user, true);

        return $this->render('templates/auth/resetPassword.html.twig', [
            'person' => $user
        ]);
    }

    #[Route('/install', name: "Install")]
    public function createFirstUser(Request $request): Response
    {

        if ($this->isInstalled()) {
            return $this->redirectToRoute($this->getUser() ? 'timesheet' : 'authLogin');
        }

        [$response, $value] = $this->formService->handleCreateForm($request, UserType::class, User::class);

        if ($response)  {
            $value->setPermissions(1);
            $hash = $this->userService->createUser($value);
            return $this->redirectToRoute("authPassword", ["hash" => $hash->getHash()]);
        }

        return $this->render("templates/management/userShow.html.twig", [
            "form" => $value
        ]);
    }

    private function isInstalled(): bool
    {
        return !!$this->userRepository->findOneBy([]);
    }


}