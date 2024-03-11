<?php
class GenGif
{
    private $gifPaths = [];
    private $gifImages = [];
    private $totalWidth;
    private $maxHeight;
    private $mergedGif;

    public function __construct($word, $gifPathPrefix = './assets/gif/')
    {
        $this->word = $word;
        $this->gifPathPrefix = $gifPathPrefix;
    }

    public function createGIF()
    {
        $this->genGifPaths();
        $this->loadGifImages();
        $this->calculateSize();
        $this->mergeImages();
        $this->outputResult();
    }

    private function genGifPaths()
    {
        $letters = str_split($this->word);
        foreach ($letters as $letter) {
            $this->gifPaths[] = $this->gifPathPrefix . strtolower($letter) . '.gif';
        }
    }

    private function loadGifImages()
    {
        foreach ($this->gifPaths as $gifPath) {
            if (file_exists($gifPath) && $gifPath !== './assets/gif/ .gif') 
            {
                $this->gifImages[] = new Imagick($gifPath);
            }
            elseif ($gifPath === './assets/gif/ .gif') {
                $spaceImage = new Imagick();
                $spaceImage->newImage(170, 170, 'none');
                $this->gifImages[] = $spaceImage;
            }
            else {
                echo 'Ошибка', die;
            }
        }
    }

    private function calculateSize()
    {
        $widths = [];
        $heights = [];

        foreach ($this->gifImages as $gif) 
        {
            $widths[] = $gif->getImageWidth();
            $heights[] = $gif->getImageHeight();
        }
        $this->totalWidth = array_sum($widths);
        $this->maxHeight = max($heights);
    }

    private function mergeImages()
    {
        $this->mergedGif = new Imagick();
        $this->mergedGif->setFormat('gif');
        $xOffset = 0;

        foreach ($this->gifImages as $gif) 
        {
            $gif->setIteratorIndex(0);
        }

        $frameLimit = 13;

        for ($i = 0; $i < $frameLimit; $i++) 
        {
            $this->mergedGif->newImage($this->totalWidth, $this->maxHeight, 'none');
            $this->mergedGif->setimagedispose(2);

            foreach ($this->gifImages as $gif) 
            {
                $this->mergedGif->compositeImage($gif, Imagick::COMPOSITE_DEFAULT, $xOffset, 0);
                $xOffset += $gif->getImageWidth();
                $gif->nextImage();
            }
            $xOffset = 0;
        }

        $this->mergedGif->setIteratorIndex(0);
    }

    private function outputResult()
    {
        header('Content-Type: image/' . $this->mergedGif->getImageFormat());
        echo $this->mergedGif->getimagesblob();
    }
}