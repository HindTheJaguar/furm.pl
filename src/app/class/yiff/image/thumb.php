<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-09-18, 15:03:22
 */
class yiff_image_thumb {

    /**
     * Katalog z miniaturami
     * @var string
     */
    public $thumbdir;
    
    /**
     * Informacjie o zdjęciu
     * @var array
     */
    public $info = [];

    /**
     * Katalog roboczy
     * @var string
     */
    public $imageroot;

    /**
     * Konstruktor
     * @param string $file relatywna ścieżka do pliku
     */
    public function __construct($file) {
        $this->file = $file;
        list (   
                $this->info['width'],
                $this->info['height'],
                $this->info['type']
                ) = getimagesize($file);
    }

    /**
     * Tworzy miniature przyciętą do kwadrata
     * @param integer $max wielkość boku
     * @throws yiff_image_exception
     */
    function cube($max = 200) {
        
        if ($this->info['width'] < $max) {
            $max = $this->info['width'];
        } elseif ($this->info['height'] < $max) {
            $max = $this->info['height'];
        }
        
        if ($this->info['width'] > $this->info['height']) {
            $pe = $this->info['width'] / $this->info['height'];
            $new_width = $max * $pe;
            $new_height = $max;
            $xl = (int) ($new_width - $max) / 2;
            $yt = 0;
        } else {
            $pe = $this->info['height'] / $this->info['width'];
            $new_width = $max;
            $new_height = $max * $pe;
            $xl = 0;
            $yt = (int) ($new_height - $max) / 2;
        }

        $image_p = imagecreatetruecolor($max, $max);
        $image = $this->_createBase();
        imagecopyresampled($image_p, $image, 0, 0, $xl, $yt, $new_width, $new_height, $this->info['width'], $this->info['height']);
//                                          xl  yg
        $this->image_p = $image_p;
    }

    /**
     * Tworzy proporcjonalną miniaturkę
     * 
     * @param $max maksymalna wielkość boku
     * @throws yiff_image_exception
     */
    function normal($max = 200) {

        if ($this->info['width'] < $this->info['height']) {
            $pe = $this->info['width'] / $this->info['height'];
            $new_width = $max * $pe;
            $new_height = $max;
        } else {
            $pe = $this->info['height'] / $this->info['width'];
            $new_width = $max;
            $new_height = $max * $pe;
        }


// Resample
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = $this->_createBase();
        
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
//                                          xl  yg
        $this->image_p = $image_p;

        
        return $this;
    }
    
    /**
     * Zapisuje obrazek
     * @param string $file nazwa pliku pod jakoą ma być zapisane
     */
    public function save($file) {
        return imagepng($this->image_p, $file.'.png');
    }
    
    /**
     * Wyświetla obrazek
     */
    public function render() {
        header('Content-Type: image/png');
        imagepng($this->image_p);
    }

    protected function _createBase() {
        switch ($this->info['type']) {
            case 1: 
                $image = imagecreatefromgif($this->file);
                break;
            case 2: 
                $image = imagecreatefromjpeg($this->file);
                break;
            case 3: 
                $image = imagecreatefrompng($this->file);
                break;
            default: 
                throw new yiff_image_exception("Unkown filetype (file $filename, typ $otype)");
        }
        return $image;
    }
}