<?php
/*
Copyright (C) 2010 by Tyler Kennedy <tk@tkte.ch>, Matvei Stefarov
 
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
 
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.
 
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
class Application_Model_SkinRenderer {
    private
    	$image = NULL;
 
    // Loads the skin image from a file path
    public function AssignSkinFromFile ($file) {
        if ($this->image != NULL) {
            imagedestroy($this->image);
        }
        if(($this->image = imagecreatefrompng($file)) == False) {
            // Error occured
            throw new Exception("Could not open PNG file.");
        }
        if(!$this->Valid()) {
            throw new Exception("Invalid skin image.");
        }
    }
 
    // Loads the skin image from a string
    public function AssignSkinFromString ($data) {
        if ($this->image != NULL) {
            imagedestroy($this->image);
        }
        if(($this->image = imagecreatefromstring($data)) == False) {
            // Error occured
            throw new Exception("Could not load image data from string.");
        }
        if(!$this->Valid()) {
            throw new Exception("Invalid skin image.");
        }
    }
 
    // Returns the width of the skin.
    public function Width () {
        if($this->image != NULL) {
            return imagesx($this->image);
        } else {
            throw new Exception("No skin loaded.");
        }
    }
 
    // Returns the height of the skin.
    public function Height () {
        if($this->image != NULL) {
            return imagesy($this->image);
        } else {
            throw new Exception("No skin loaded.");
        }
    }
 
    // Returns true if the skin has valid dimensions, false otherwise.
   public  function Valid () {
        return ($this->Width() != 64 || $this->Height() != 32) ? False : True;
    }
 
    // Returns an image handle consisting of an (optionally) scaled front view of the skin.
    // $r, $g, $b are used to construct the background color.
    public function FrontImage ($scale = 1, $r = 255, $g = 255, $b = 255) {
        $newWidth = 16 * $scale;
        $newHeight = 32 * $scale;
 
        $newImage = imagecreatetruecolor(16, 32);
        $background = imagecolorallocate($newImage, $r, $g, $b);
        imagefilledrectangle($newImage, 0, 0, 16, 32, $background);
 
        //copy head
        imagecopy($newImage, $this->image, 4, 0, 8, 8, 8, 8);
        //copy head mask
        $this->imagecopyalpha($newImage, $this->image, 4, 0, 40, 8, 8, 8, imagecolorat($this->image, 63, 0));
        //copy body
        imagecopy($newImage, $this->image, 4, 8, 20, 20, 8, 12);
        //copy left leg
        imagecopy($newImage, $this->image, 8, 20, 4, 20, 4, 12);
        //copy right leg
        imagecopy($newImage, $this->image, 4, 20, 4, 20, 4, 12);
        //copy right arm
        imagecopy($newImage, $this->image, 12, 8, 44, 20, 4, 12);
        //copy left arm
        imagecopy($newImage, $this->image, 0, 8, 44, 20, 4, 12);
 
        // Scale the image
        if($scale != 1) {
            $resize = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($resize, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, 16, 32);
            imagedestroy($newImage);
            return $resize;
        }
 
        return $newImage;
    }
 
    // Returns an image handle consisting of an (optionally) scaled back view of the skin.
    // $r, $g, $b are used to construct the background color.
    public function BackImage ($scale = 1, $r = 255, $g = 255, $b = 255) {
        $newWidth = 16 * $scale;
        $newHeight = 32 * $scale;
 
        $newImage = imagecreatetruecolor(16, 32);
        $background = imagecolorallocate($newImage, $r, $g, $b);
        imagefilledrectangle($newImage, 0, 0, 16, 32, $background);
 
        //copy head
        imagecopy($newImage, $this->image, 4, 0, 24, 8, 8, 8);
        //copy head mask
        $this->imagecopyalpha($newImage, $this->image, 4, 0, 56, 8, 8, 8, imagecolorat($this->image, 63, 0));
        //copy body
        imagecopy($newImage, $this->image, 4, 8, 32, 20, 8, 12);
        //copy left leg
        imagecopy($newImage, $this->image, 8, 20, 12, 20, 4, 12);
        //copy right leg
        imagecopy($newImage, $this->image, 4, 20, 12, 20, 4, 12);
        //copy right arm
        imagecopy($newImage, $this->image, 12, 8, 52, 20, 4, 12);
        //copy left arm
        imagecopy($newImage, $this->image, 0, 8, 52, 20, 4, 12);
 
        // Scale the image
        if($scale != 1) {
            $resize = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($resize, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, 16, 32);
            imagedestroy($newImage);
            return $resize;
        }
 
        return $newImage;
    }
 
    // Returns an image handle consisting of an (optionally) scaled combined view of the skin.
    // $r, $g, $b are used to construct the background color.
    public function CombinedImage ($scale = 1, $r = 255, $g = 255, $b = 255) {
        $newWidth = 37 * $scale;
        $newHeight = 32 * $scale;
 
        $newImage = imagecreatetruecolor(37, 32);
        $background = imagecolorallocate($newImage, $r, $g, $b);
        imagefilledrectangle($newImage, 0, 0, 37, 32, $background);
 
        //copy head
        imagecopy($newImage, $this->image, 4, 0, 8, 8, 8, 8);
        //copy head mask
        $this->imagecopyalpha($newImage, $this->image, 4, 0, 40, 8, 8, 8, imagecolorat($this->image, 63, 0));
        //copy body
        imagecopy($newImage, $this->image, 4, 8, 20, 20, 8, 12);
        //copy left leg
        imagecopy($newImage, $this->image, 8, 20, 4, 20, 4, 12);
        //copy right leg
        imagecopy($newImage, $this->image, 4, 20, 4, 20, 4, 12);
        //copy right arm
        imagecopy($newImage, $this->image, 12, 8, 44, 20, 4, 12);
        //copy left arm
        imagecopy($newImage, $this->image, 0, 8, 44, 20, 4, 12);
 
 
        //copy head
        imagecopy($newImage, $this->image, 25, 0, 24, 8, 8, 8);
        //copy head mask
        $this->imagecopyalpha($newImage, $this->image, 25, 0, 56, 8, 8, 8, imagecolorat($this->image, 63, 0));
        //copy body
        imagecopy($newImage, $this->image, 25, 8, 32, 20, 8, 12);
        //copy left leg
        imagecopy($newImage, $this->image, 29, 20, 12, 20, 4, 12);
        //copy right leg
        imagecopy($newImage, $this->image, 25, 20, 12, 20, 4, 12);
        //copy right arm
        imagecopy($newImage, $this->image, 33, 8, 52, 20, 4, 12);
        //copy left arm
        imagecopy($newImage, $this->image, 21, 8, 52, 20, 4, 12);
 
        // Scale the image
        if($scale != 1) {
            $resize = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($resize, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, 37, 32);
            imagedestroy($newImage);
            return $resize;
        }
 
        return $newImage;
    }
 
    // Attempts to compensate for people (incorrectly) filling the head layers with random solid colors
    // Instead of leaving them 100% Alpha.
    public function imagecopyalpha($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $w, $h, $bg) {
        for($i = 0; $i < $w; $i++) {
            for($j = 0; $j < $h; $j++) {
 
                $rgb = imagecolorat($src, $src_x + $i, $src_y + $j);
 
                if(($rgb & 0xFFFFFF) == ($bg & 0xFFFFFF)) {
                    $alpha = 127;
                } else {
                    $colors = imagecolorsforindex($src, $rgb);
                    $alpha = $colors["alpha"];
                }
                imagecopymerge($dst, $src, $dst_x + $i, $dst_y + $j, $src_x + $i, $src_y + $j, 1, 1, 100 - (($alpha / 127) * 100));
            }
        }
    }
 
    public function __destructor () {
        if ($this->image != NULL) {
            imagedestroy($this->image);
        }
    }
}
