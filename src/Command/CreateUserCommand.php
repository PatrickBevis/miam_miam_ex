<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Crée un utilisateur avec un mot de passe hashé et des rôles.',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('firstName', InputArgument::REQUIRED, 'users first name')
            ->addArgument('lastName', InputArgument::REQUIRED, 'users last name')
            ->addArgument('email', InputArgument::REQUIRED, 'users email')
            ->addArgument('password', InputArgument::REQUIRED, 'password not hashed (it will be later)')
            ->addArgument('roles', InputArgument::OPTIONAL, 'separated roles with virgules (ex: ROLE_ADMIN,ROLE_USER)', 'ROLE_USER')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $firstName = (string) $input->getArgument('firstName');
        $lastName = (string) $input->getArgument('lastName');
        $email = (string) $input->getArgument('email');
        $plainPassword = (string) $input->getArgument('password');
        $roleString = (string) $input->getArgument('roles');

        // On découpe la chaîne "ROLE_ADMIN,ROLE_USER" en tableau ["ROLE_ADMIN", "ROLE_USER"]
        $roles = array_map('trim', explode(',', $roleString));
        $roles = array_values(array_filter($roles));

        $user = new User();
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setEmail($email);
        $user->setRoles($roles);

        // Le mot de passe est hashé avant l’enregistrement.
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // persist = Doctrine prépare l’insertion
        // flush = Doctrine exécute réellement l’insertion en base
        $this->em->persist($user);
        $this->em->flush();
        
        $output->writeln('User first name : '.$firstName);
        $output->writeln('User last name : '.$lastName);
        $output->writeln('User email : '.$email);
        //$output->writeln('Voici le mot de passe : '.$plainPassword);
        //$output->writeln('Voici le hash : '.$hashedPassword);
        $output->writeln('Roles : '.implode(', ', $roles));
        
        return Command::SUCCESS;
    }
}