<?php
namespace Pickle\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pickle\Base\Interfaces;
use Pickle\Package\Command\Validate;

class ValidateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('validate')
            ->setDescription('Validate a PECL extension')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to the PECL extension root directory (default pwd)',
                getcwd()
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = rtrim($input->getArgument('path'), '/\\');
    	$helper = $this->getHelper('package');
	
    	$cb = function(Interfaces\Package $package) use ($helper, $output) {
		/* TODO Rework this to use the Info package command */
		$helper->showInfo($output, $package);
		$output->writeln(trim($package->getDescription()));
	};

	$validate = Validate::factory($path, $cb);
	$validate->process();
    }
}
