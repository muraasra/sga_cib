<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('date_diff', [$this, 'dateDiff']),
        ];
    }

    public function dateDiff(\DateTime $date1, \DateTime $date2)
    {
        return date_diff($date1, $date2);
    }
}
