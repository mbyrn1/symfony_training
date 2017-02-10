<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 3:06 PM
 */

namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CoolGuysCommand extends Command
{
    protected function configure()
    {
        $this->setName('cool:guys');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $style->error('You did it wrong!');
        $output->writeln('Nice!');
    }
}
