<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Core\Exceptions\FileNotFoundException;
use SigmaPHP\Filesystem\Filesystem;
use PassGen\PassGen;

/**
 * Create Secret Command.
 */
class CreateSecret extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:secret');
        $this->setDescription(
            'Generate a new app secret key , and save it into .env file'
        );
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path('.env');
        $filesystem = new Filesystem();

        // check if the .env file is exist
        if (!$filesystem->exists($path)) {
            throw new FileNotFoundException("No .env file was found");
        }

        // generate new secret key
        $key = PassGen::generate(32);

        // replace invalid symbols from the generated key
        $key  = str_replace(['#', '\'', '"'], ['Z', 'X', '7'], $key);

        $envFile = $filesystem->read($path);

        if (strpos($envFile, 'APP_SECRET_KEY=""')) {
            $emptySecretKey = 'APP_SECRET_KEY=""';
            $secretKey = 'APP_SECRET_KEY="' . $key . '"';

            $envFile = str_replace($emptySecretKey, $secretKey, $envFile);
        }
        else if (!empty(env('APP_SECRET_KEY'))) {
            $envFile = str_replace(env('APP_SECRET_KEY'), $key, $envFile);
        }
        else if (!strpos($envFile, 'APP_SECRET_KEY')) {
            $envFile .= 'APP_SECRET_KEY=' . $key;
        }
        else {
            $envFile = str_replace(
                'APP_SECRET_KEY=',
                'APP_SECRET_KEY=' . $key,
                $envFile
            );
        }

        $filesystem->write($path, $envFile);

        $this->success('App secret key was generated successfully');
    }
}
