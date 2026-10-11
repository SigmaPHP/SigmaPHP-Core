<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateView;

/**
 * Create View Command Test
 */
class CreateViewTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'templates/users_table.template.html';

        $command = $this->commandFactory(CreateView::class);

        $command->getArguments()['name']->setValue('users_table');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}
