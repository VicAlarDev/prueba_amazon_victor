<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-test-user',
    description: 'Creates a test user account',
)]
class CreateTestUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $testEmail = 'test@example.com';
        $testPassword = 'test1234';
        $testFullName = 'Test User';

        if ($this->entityManager->getRepository(User::class)->findOneBy(['email' => $testEmail])) {
            $output->writeln('Test user already exists.');
            return Command::SUCCESS;
        }

        $user = new User();
        $user->setEmail($testEmail);
        $user->setPassword($this->passwordHasher->hashPassword($user, $testPassword));
        $user->setFullname($testFullName);
        $user->setRoles(['ROLE_USER', 'ROLE_TEST']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln("Test user created successfully with email: $testEmail");
        $output->writeln("Password: $testPassword");
        return Command::SUCCESS;
    }
}
