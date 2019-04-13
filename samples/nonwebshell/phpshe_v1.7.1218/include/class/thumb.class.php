<?php   
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2011-0501 koyshe <koyshe@gmail.com>
 */ 

class thumb {   
    // *** Class variables   
    private $image;   
    private $width;
    private $height;   
    private $imageResized;

	function __construct($fileName, $new_path, $new_width, $new_height) {
		//打开一个图片
		$this->image = $this->open_image($fileName);
		//获取图片宽高
		$this->width  = imagesx($this->image);
		$this->height = imagesy($this->image);

		if ($new_width == 'auto') {
			$type = 'auto_width';
		}
		elseif ($new_height == 'auto') {
			$type = 'auto_height';
		}
		elseif (stripos($new_width, '_') === 0 && stripos($new_height, '_') === 0) {
			$type = 'fix';
		}
		else {
			$type = 'diy';
		}
		$this->mark_image($new_width, $new_height, $type);
		$this->save_image($new_path, 90);
	}
    private function open_image($file) {   
        // *** Get extension   
        $extension = strtolower(strrchr($file, '.'));
        switch($extension) {   
            case '.jpg':   
            case '.jpeg':   
                $img = @imagecreatefromjpeg($file);   
                break;   
            case '.gif':   
                $img = @imagecreatefromgif($file);   
                break;   
            case '.png':   
                $img = @imagecreatefrompng($file);
                break;   
            default:   
                $img = false;   
                break;   
        }   
        return $img;   
    }
    public function mark_image($new_width, $new_height, $type='diy') {
		switch ($type) {   
            case 'diy':
                $size_arr = $this->get_diysize($new_width, $new_height);   
                $fix_width = $size_arr['fix_width'];   
                $fix_height = $size_arr['fix_height'];   
            break;   
            case 'fix': 
                $fix_width = substr($new_width, 1);
                $fix_height = substr($new_height, 1);
            break;
            case 'auto_width':
                $fix_width = $this->get_autowidth($new_height);
                $fix_height= $new_height;   
            break;   
            case 'auto_height':
                $fix_width = $new_width;
                $fix_height= $this->get_autoheight($new_width);
            break;   
            /*case 'diy': 
                $optimalWidth = $new_width;   
                $optimalHeight = $new_height;   
            break;*/
        }
        // *** Resample - create image canvas of x, y size
        if ($type == 'diy') {
			$pos_x = abs(($new_width - $fix_width) / 2);
			$pos_y = abs(($new_height - $fix_height) / 2);
			$this->imageResized = imagecreatetruecolor($new_width, $new_height);   
 	        $fff = imagecolorallocate($this->imageResized, 255, 255, 255);
	        imagefill($this->imageResized, 0, 0, $fff);
        	imagecopyresampled($this->imageResized, $this->image, $pos_x, $pos_y, 0, 0, $fix_width, $fix_height, $this->width, $this->height);         
        }
        else {
			$this->imageResized = imagecreatetruecolor($fix_width, $fix_height);   
        	imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $fix_width, $fix_height, $this->width, $this->height);         
        }
    } 
	public function save_image($savePath, $imageQuality="90") {
		$Path = substr($savePath, 0, strripos($savePath, '/'));
		!is_dir($Path) && mkdir($Path , 0777 ,true);
		// *** Get extension
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);
		switch ($extension) {
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);  
				}
			break;
			case '.gif':
				if (imagetypes() & IMG_GIF) {
					imagegif($this->imageResized, $savePath); 
				}
			break;
			case '.png':
				// *** Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imageQuality/100) * 9);
				// *** Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9 - $scaleQuality;
				if (imagetypes() & IMG_PNG) {
					imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}   
			break;
		}
		imagedestroy($this->imageResized);   
	}

    ## --------------------------------------------------------   
    private function get_autowidth($new_height) {
		return $new_height * $this->width / $this->height;
	}
    private function get_autoheight($new_width) {
		return $new_width * $this->height / $this->width;
	}
	private function get_diysize($new_width, $new_height) {
		$old_rate = $this->width / $this->height;
		$new_rate = $new_width / $new_height;
		if ($new_rate > $old_rate) {
			$fix_height = $new_height;
			$fix_width = $this->get_autowidth($fix_height);
		}
		else {
			$fix_width = $new_width;
			$fix_height = $this->get_autoheight($fix_width);
		}
		return array('fix_width' => $fix_width, 'fix_height' => $fix_height);
    }
}   
?>