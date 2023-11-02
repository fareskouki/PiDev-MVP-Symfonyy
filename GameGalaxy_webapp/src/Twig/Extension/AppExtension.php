<?php


namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'filterFunction']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generate_stars', [$this, 'generateStars'], ['is_safe' => ['html']]),
        ];
    }

    public function filterFunction($value)
    {
        // TODO: Implement filterFunction() method.
    }

    public function generateStars($rating, $maxStars = 5)
    {
        $maxStars = min($maxStars, 5); // Ensure $maxStars is not greater than 5
        $fullStars = floor($rating);
        $emptyStars = $maxStars - $fullStars;
        $halfStar = round(($rating - $fullStars) * 2);
    
        $html = '';
        // full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="fas fa-star"></i>';
        }
        // half star
        if ($halfStar > 0) {
            $html .= '<i class="fas fa-star-half-alt"></i>';
        }
        // empty stars
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="far fa-star"></i>';
        }
    
        return $html;
    }
}
