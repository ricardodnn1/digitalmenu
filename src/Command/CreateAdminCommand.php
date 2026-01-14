<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * CreateAdmin command - Creates a new admin user
 */
class CreateAdminCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        $parser
            ->setDescription('Create a new admin user')
            ->addArgument('username', [
                'help' => 'The username for the admin',
                'required' => true,
            ])
            ->addArgument('password', [
                'help' => 'The password for the admin',
                'required' => true,
            ])
            ->addOption('restaurant-id', [
                'short' => 'r',
                'help' => 'The restaurant ID to associate with the admin',
                'default' => '1',
            ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $username = $args->getArgument('username');
        $password = $args->getArgument('password');
        $restaurantId = (int)$args->getOption('restaurant-id');

        $adminUsers = $this->fetchTable('AdminUsers');

        // Check if user already exists
        $existing = $adminUsers->find()
            ->where(['username' => $username])
            ->first();

        if ($existing) {
            $io->error("User '{$username}' already exists!");
            return self::CODE_ERROR;
        }

        // Create new admin user
        $admin = $adminUsers->newEntity([
            'username' => $username,
            'password' => $password,
            'restaurant_id' => $restaurantId,
        ]);

        if ($adminUsers->save($admin)) {
            $io->success("Admin user '{$username}' created successfully!");
            return self::CODE_SUCCESS;
        }

        $io->error('Failed to create admin user:');
        foreach ($admin->getErrors() as $field => $errors) {
            foreach ($errors as $error) {
                $io->error(" - {$field}: {$error}");
            }
        }

        return self::CODE_ERROR;
    }
}
