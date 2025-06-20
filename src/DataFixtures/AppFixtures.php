<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {

        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setNom("Utilisateur $i");
            $user->setEmail("user$i@example.com");

            // Hash du mot de passe "motdepasse$i"
            $hashedPassword = $this->passwordHasher->hashPassword($user, "motdepasse$i");
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $users[] = $user;
        }

        // Créer quelques catégories
        $categories = [];
        foreach (['Roman', 'Science', 'Biographie'] as $catName) {
            $category = new Category();
            $category->setName($catName);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Créer des livres
        for ($i = 1; $i <= 10; $i++) {
            $book = new Book();
            $book->setTitre("Livre $i");
            $book->setAuteur("Auteur $i");

            // Générer un ISBN valide de 10 caractères (lettres, chiffres, tirets)
            $isbn = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-'), 0, 10));
            $book->setIsbn($isbn);

            // Associer un utilisateur propriétaire (objet User)
            $book->setUser($users[array_rand($users)]);

            // Associer une ou deux catégories aléatoirement
            shuffle($categories);
            $book->addCategory($categories[0]);
            if (rand(0, 1)) {
                $book->addCategory($categories[1]);
            }

            $manager->persist($book);
        }

        // Enregistrer en base
        $manager->flush();
    }
}
