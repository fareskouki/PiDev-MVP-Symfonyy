<?php

namespace App\Services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;



class QrcodeService
{
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($query)
    {
        $url = "Réservation vérifiée avec succès! Faite par l'utilisateur ";

        $objDateTime = new \DateTIme(datetime: 'NOW');
        $dateString = $objDateTime->format(format: 'd-m-Y H:i:s');

        $result = $this->builder
            ->data(data: $url . $query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(size: 200)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->logoPath(__DIR__ . '\logo.png')

            ->build();
        //Generate png file name
        $namePng = uniqid(prefix: '', more_entropy: '') . '.png';
        //Save png file
        $result->saveToFile((dirname(path: __DIR__, levels: 2) . '/public/FRONT/assets/images/qrcode/' . $namePng));

        return $result->getDataUri();
    }
}
