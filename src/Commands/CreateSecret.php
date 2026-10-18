<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;
use SigmaPHP\Core\Exceptions\PathNotFoundException;
use PassGen\PassGen;

/**
 * Create Secret Command.
 */
class CreateSecret extends CoreCommand
{
    /**
     * @var int secret key's length
     */
    const APP_SECRET_KEY_LENGTH = 32;

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
        $path = rootPath('.env');

        // check if the .env file is exist
        if (!$this->filesystem->exists($path)) {
            throw new PathNotFoundException("No .env file was found");
        }

        // generate new secret key
        $key = PassGen::generate(self::APP_SECRET_KEY_LENGTH);

        // replace invalid symbols from the generated key
        $key  = str_replace(['#', '\'', '"'], ['Z', 'X', '7'], $key);

        $envFile = $this->filesystem->read($path);

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

        $this->filesystem->write($path, $envFile);

        $this->success('App secret key was generated successfully');
    }
}
