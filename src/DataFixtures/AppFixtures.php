<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Tache;
use App\Entity\Tag;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $tagSymfony = new Tag();
        $tagSymfony->setName('Symfony');
        $manager->persist($tagSymfony);

        $tagReact = new Tag();
        $tagReact->setName('React');
        $manager->persist($tagReact);

        $tagPython = new Tag();
        $tagPython->setName('Python');
        $manager->persist($tagPython);

        // #####################################

        $status1 = new Status();
        $status1->setName('To Do');
        $manager->persist($status1);

        $status2 = new Status();
        $status2->setName('Doing');
        $manager->persist($status2);

        $status3 = new Status();
        $status3->setName('Done');
        $manager->persist($status3);

        // #####################################

        $project = new Project();
        $project->setName('Tasklinker');
        $project->setStartDate(new \DateTime('2026-01-01'));
        $project->setDeadline(new \DateTime('2026-12-31'));
        $project->setArchived(false);
        $project->setStatus($status3);
        $project->setTag($tagSymfony);
        $manager->persist($project);

        $project2 = new Project();
        $project2->setName('Tasklinker_test');
        $project2->setArchived(true);
        $project2->setStartDate(new \DateTime('2025-01-01'));
        $project2->setDeadline(new \DateTime('2025-12-31'));
        $project2->setStatus($status1);
        $project2->setTag($tagReact);
        $manager->persist($project2);

        // #####################################

        $user1 = new Users();
        $user1->setFirstName('John');
        $user1->setLastName('Doe');
        $user1->setEmail('john.doe@example.fr');
        $user1->setPassword($this->hasher->hashPassword($user1, 'john.doe'));
        $user1->setAccessLevel('Chef de projet');
        $user1->setContractType('CDI');
        $user1->setEnterDate(new \DateTime('2025-01-01'));
        $user1->setIsActive(true);
        $user1->addProject($project);
        $manager->persist($user1);

        $user2 = new Users();
        $user2->setFirstName('Alice');
        $user2->setLastName('Doe');
        $user2->setEmail('alice.doe@example.fr');
        $user2->setPassword($this->hasher->hashPassword($user2, 'alice.doe'));
        $user2->setAccessLevel('Admin');
        $user2->setContractType('CDD');
        $user2->setEnterDate(new \DateTime('2025-02-01'));
        $user2->setIsActive(true);
        $user2->addProject($project);
        $manager->persist($user2);

        $user3 = new Users();
        $user3->setFirstName('Fabrice');
        $user3->setLastName('Martin');
        $user3->setEmail('fabrice.martin@example.fr');
        $user3->setPassword($this->hasher->hashPassword($user3, 'fabrice.martin'));
        $user3->setAccessLevel('Développeur');
        $user3->setContractType('Freelance');
        $user3->setEnterDate(new \DateTime('2025-03-01'));
        $user3->setIsActive(true);
        $user3->addProject($project);
        $user3->addProject($project2);
        $manager->persist($user3);

        // #####################################

        $tache1 = new Tache();
        $tache1->setName('Créer la maquette de la page d\'accueil');
        $tache1->setDescription('Concevoir le design de la page d\'accueil avec 
        Figma');
        $tache1->setDeadline(new \DateTime('2026-04-10'));
        $tache1->setIdProject($project);
        $tache1->setIdUser($user1);
        $tache1->setIdStatus($status1);
        $manager->persist($tache1);

        $tache2 = new Tache();
        $tache2->setName('Développer l\'API d\'authentification');
        $tache2->setDescription('Créer les endpoints pour login/logout/register');
        $tache2->setDeadline(new \DateTime('2026-04-20'));
        $tache2->setIdProject($project2);
        $tache2->setIdUser($user2);
        $tache2->setIdStatus($status2);
        $manager->persist($tache2);

        // #####################################

        $manager->flush();
    }
}
