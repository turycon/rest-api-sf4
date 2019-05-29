<?php

namespace App\DataFixtures;


use App\Entity\Billing;
use App\Entity\Client;
use App\Entity\Country;
use App\Entity\MainConfiguration;
use App\Entity\Market;
use App\Entity\Project;
use App\Entity\ProjectProfile;
use App\Entity\State;
use App\Entity\User;

use App\Entity\Venue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{


    private $passwordEncoder;
    private $faker;

    private $proyectosCreados;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
        $this->proyectosCreados = 1;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->loadUsers($manager);
        $this->loadProjects($manager);
        $this->loadClients($manager);
        $this->loadCountries($manager);
        $this->loadMarkets($manager);
        $this->loadVenues($manager);
        $this->loadStates($manager);
        $this->loadMainConfiguration($manager);
        $this->loadProjectProfiles($manager);
        $this->loadProjectBillings($manager);

    }

    // FakeData Project Billings
    public function loadProjectBillings(ObjectManager $manager){

        for ($a=1; $a < $this->proyectosCreados; $a++) {

            $project = $this->getReference("proyect_$a");

            for($j=1; $j <= rand(1,8) ; $j++){

                $billing = new Billing();

                $billing->setNumber($this->faker->randomNumber(5));
                $billing->setDate($this->faker->dateTimeThisYear('now'));
                $billing->setAmount($this->faker->randomFloat(2,0));
                $billing->setCategory('Ingreso');
                $billing->setStatus('Pagado');
                $billing->setCreateDate($this->faker->dateTimeThisYear('now'));
                $billing->setPaymentDate($this->faker->dateTimeThisYear('now'));
                $billing->setUsuario($project->getUsuario());
                $billing->setProject($project);

                $manager->persist($billing);
            }

        }

        $manager->flush();

    }

    // FakeData perfiles de proyecto
    public function loadProjectProfiles(ObjectManager $manager){

        for ($a=1; $a < $this->proyectosCreados; $a++) {

            $projectProfile = new ProjectProfile();

            $project = $this->getReference("proyect_$a");

            $projectProfile->setPax($this->faker->randomNumber(4));
            $projectProfile->setBudget($this->faker->randomFloat(2,0));
            $projectProfile->setBalance($this->faker->randomFloat(2,0));
            $projectProfile->setBalanceDate($this->faker->dateTimeThisYear('now'));
            $projectProfile->setBilling($this->faker->randomFloat(2,0));
            $projectProfile->setBillingDate($this->faker->dateTimeThisYear('now'));
            $projectProfile->setBillingStatus($this->faker->boolean(50));
            $projectProfile->setRevenue($this->faker->randomFloat(2,0));
            $projectProfile->setRevenuePercent($this->faker->randomNumber(2));
            $projectProfile->setRevenueProspection($this->faker->randomFloat(2,0));
            $projectProfile->setPaymentDate($this->faker->dateTimeThisYear('now'));
            $projectProfile->setPaymentDays($this->faker->randomNumber(2));
            $projectProfile->setFinancialStatus($this->faker->boolean(50));
            $projectProfile->setOperationStatus($this->faker->boolean(50));
            $projectProfile->setAuditStatus($this->faker->boolean(50));
            $projectProfile->setAuditStatusIncomplete($this->faker->boolean(50));
            $projectProfile->setUsuario($project->getUsuario());
            $projectProfile->setCreateDate($this->faker->dateTimeThisYear('now'));
            $projectProfile->setProject($project);

            $manager->persist($projectProfile);

        }

        $manager->flush();

    }

    // FakeData Configuración inicial
    public function loadMainConfiguration(ObjectManager $manager){

        $config = new MainConfiguration();

        $config->setBalanceDays(30);
        $config->setBillingdays(30);
        $config->setFinancialdays(30);
        $config->setAuditdays(30);
        $config->setGobDays(45);
        $config->setAsocDays(30);
        $config->setCorpDays(30);
        $config->setMinPercentRevenue(15);
        $config->setUsuario($this->getReference("reg_usuario_1"));

        $manager->persist($config);

        $manager->flush();

    }

    // FakeData para estados
    public function loadStates(ObjectManager $manager){

        for ($j=1; $j < 33; $j++) {

            $state = new State();

            $state->setName($this->faker->state());
            $state->setStkey($this->faker->countryCode());
            $state->setUsuario($this->getReference("reg_usuario_1"));
            $state->setCreateDate($this->faker->dateTimeThisYear('now'));

            $manager->persist($state);

        }

        $manager->flush();
    }

    // FakeData para sedes
    public function loadVenues(ObjectManager $manager){

        for ($j=1; $j < 51; $j++) {

            $venue = new Venue();

            $venue->setName($this->faker->company());
            $venue->setComments($this->faker->realText(120));
            $venue->setUsuario($this->getReference("reg_usuario_1"));
            $venue->setCreateDate($this->faker->dateTimeThisYear('now'));

            $manager->persist($venue);

        }

        $manager->flush();
    }

    // FakeData para mercados
    public function loadMarkets(ObjectManager $manager){

        for ($j=1; $j < 6; $j++) {

            $market = new Market();

            $market->setName($this->faker->realText(15));
            $market->setComments($this->faker->realText(120));
            $market->setUsuario($this->getReference("reg_usuario_1"));
            $market->setCreateDate($this->faker->dateTimeThisYear('now'));

            $manager->persist($market);

        }

        $manager->flush();
    }

    // FakeData para países
    public function loadCountries(ObjectManager $manager){

        for ($j=1; $j < 21; $j++) {

            $client = new Country();

            $client->setName($this->faker->country());
            $client->setCtkey($this->faker->countryCode());
            $client->setUsuario($this->getReference("reg_usuario_1"));
            $client->setCreateDate($this->faker->dateTimeThisYear('now'));

            $manager->persist($client);

        }

        $manager->flush();
    }

    // FakeData para Clientes
    public function loadClients(ObjectManager $manager){

        for ($a=1; $a < 16; $a++) {

            for ($j=1; $j < rand(1,5); $j++) {

                $client = new Client();

                $client->setName($this->faker->company());
                $client->setComments($this->faker->realText(150));
                $client->setUsuario($this->getReference("reg_usuario_$a"));
                $client->setCreateDate($this->faker->dateTimeThisYear('now'));

                $manager->persist($client);

            }

        }

        $manager->flush();

    }

    // FakeData para Proyectos
    public function loadProjects(ObjectManager $manager){

        for ($a=1; $a < 16; $a++) {

            for ($j=1; $j <= rand(1,8); $j++) {

                $project = new Project();

                $project->setName($this->faker->realText(120));
                $project->setStartDate($this->faker->dateTimeThisYear('now'));
                $project->setEndDate($this->faker->dateTimeThisYear('now'));
                $project->setUsuario($this->getReference("reg_usuario_$a"));
                $project->setCreateDate($this->faker->dateTimeThisYear('now'));

                $this->setReference("proyect_" . $this->proyectosCreados, $project);

                $manager->persist($project);

                $this->proyectosCreados++;

            }

        }

        $manager->flush();

    }

    // FakeDate para usuarios
    public function loadUsers(ObjectManager $manager){

        $user = new User();

        $user->setEmail('lcazares@tycgroup.com')
            ->setFullname('Luis Fernando Cázares')
            ->setMobil('5522714689')
            ->setPhone('51487539')
            ->setPosition('Gerente IT')
            ->setUsername('CazaresLuis')
            ->setPassword(
                $this->passwordEncoder->encodePassword($user,'Admin123#')
            )
            ->setCreateDate($this->faker->dateTimeThisYear('now'))
            ->setRoles([User::ROLE_SUPERADMIN]);

        $this->setReference('reg_usuario_1', $user);

        $manager->persist($user);

        for ($i=2; $i < 16; $i++) {

            $user = new User();

            $user->setUsername($this->faker->userName());

            $passOK = $this->faker->password();
            $encoded = $this->passwordEncoder->encodePassword($user, $passOK);
            $user->setPassword($encoded);

            $user->setEmail($this->faker->companyEmail());
            // $user->setFullname($this->faker->firstName() . ' ' . $this->faker->lastName());
            $user->setFullname($passOK);
            $user->setPosition($this->faker->jobTitle());
            $user->setPhone($this->faker->numerify("##########"));
            $user->setMobil($this->faker->numerify("##########"));

            $user->setCreateDate($this->faker->dateTimeThisYear('now'));

            $this->setReference("reg_usuario_$i", $user);


            $manager->persist($user);
        }

        $manager->flush();

    }

}
