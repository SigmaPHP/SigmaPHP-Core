<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateProvider;

/**
 * Create Provider Command Test
 */
class CreateProviderTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'providers/UserServiceProvider.php';

        $command = $this->commandFactory(CreateProvider::class);

        $command->getArguments()['name']->setValue('User');

        $command->execute();

        $this->assertTrue(
            (bool) strpos(
                file_get_contents('config/providers.php'),
                '\App\Providers\UserServiceProvider::class,',
            )
        );

        $this->assertTrue(file_exists($targetPath));

        // remove the dummy provider!
        $original = str_replace(
            '\App\Providers\UserServiceProvider::class,',
            '',
            file_get_contents('config/providers.php'),
        );

        file_put_contents('config/providers.php', $original);
    }

    /**
     * Test provider won't be created if already exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testControllerWillNotBeCreatedIfAlreadyExists()
    {
        $targetPath = 'providers/UserServiceProvider.php';

        if (!file_exists($targetPath)) {
            touch($targetPath);
        }

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command = $this->commandFactory(CreateProvider::class);

        $command->getArguments()['name']->setValue('User');

        $command->execute();

        $this->expectOutputRegex(
            "/The service provider 'UserServiceProvider' already exists/"
        );

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
    }
}
