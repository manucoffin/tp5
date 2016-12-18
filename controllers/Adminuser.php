<?php
//ALTER TABLE `user` ADD `admin` BOOLEAN NOT NULL DEFAULT FALSE AFTER `actif`;
/** @todo sécuriser l'administration avec une connexion user */
class AdminUserController extends Controller{

	public function index(){
		$users = UserModel::getAll();
		$this->set(array('users'=>$users));
		$this->render('index');
	}

	public function createedit(){
		$id = isset($_GET['id'])?$_GET['id']:null;
		$user = new UserModel($id);
		$this->set(array('user'=>$user));
        $this->render('createedit');
	}

	public function postprocess(){
		if(count($_POST)){
			$id = isset($_GET['id'])?$_GET['id']:null;
			$user = new UserModel($id);
			$user->name = $_POST['name'];
			$user->email = $_POST['email'];
			//on met à jour le mot de passe uniquement s'il change
			if($_POST['password']!='')
				$user->password = hash('sha256', $_POST['password']);
			$user->actif = $_POST['actif'];
			$user->admin = $_POST['admin'];
			$user->save();
            
            if(isset($_FILES['photo'])){
                if($_FILES['photo']['error'] == UPLOAD_ERR_OK)
                {
                    $dossier = ROOT.'/upload/profilePics/';
                    $fichier = $_FILES['photo']['name'];//ou on peut mettre le nom de fichier que l'on veut pour être certain d'éviter les doublons
                    
                    if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier.$fichier))
                    {
                        //la fonction renvoie true, le fichier a bien été enregistré
                        $file = 'upload/profilePics/'.$_FILES['photo']['name'];
                        //on récupère l'extension de l'image:
                        $ext = explode('.', $file);
                        $ext = strtolower($ext[count($ext)-1]);
                        switch ($ext) {
                            case 'gif':
                                $source_gd_image = imagecreatefromgif($file);
                                break;
                            case 'jpeg':
                            case 'jpg':
                                $source_gd_image = imagecreatefromjpeg($file);
                                break;
                            case 'png':
                                $source_gd_image = imagecreatefrompng($file);
                                break;
                        }
                        if($source_gd_image === false)
                        {
                            echo 'erreur lors de la récupération de la source de l\'image';
                            die();
                        }
                        else
                        {
                            //on récupère la taille de notre image
                            $imgsize = getimagesize($file);
                            if($imgsize === false){
                                echo 'erreur lors de la récupération de la source de l\'image';
                                die();
                            }
                            
                            
                            
//                            $this->saveImage(50, $dossier, $id, $imgsize, $croped, $ext, $fichier);
                            
                            $this->saveImage(150, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(500, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(800, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(50, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            
                            imagedestroy($source_gd_image);
                            imagedestroy($thumbnail);
                            unlink($dossier.$fichier);
                        }
                    }
                    else
                    {
                        echo 'echec de l\'upload.';
                    }
                }
            }
		}
        
		header('Location: ' . WEBROOT . 'adminuser/index');
	}
    
    public function saveImage($thumbnailWidth, $dossier, $filename, $sourceSizes, $source_gd_image, $ext, $fichier){
        // if the size is 50 this means we want to crop
        if($thumbnailWidth == 50)
        {
            // create image with the size we want to crop
            $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailWidth);
            
            // if landscape mode
            if($sourceSizes[0]>$sourceSizes[1])
            {
                $thumbnailHeight = $thumbnailWidth;
                $thumbnailWidth = floor($thumbnailHeight*$sourceSizes[0]/$sourceSizes[1]);
                    
                $offsetX = -$thumbnailWidth/2+$thumbnailHeight/2;
                $offsetY = 0;
            }
            // if portrait
            else
            {
                $thumbnailHeight = floor($thumbnailWidth*$sourceSizes[1]/$sourceSizes[0]);
                $offsetX = 0;
                $offsetY = -$thumbnailHeight/2 + $thumbnailWidth/2; 
            }
        
            
            $imageName = $dossier.$filename.'_profile';

            // copy the image to the final canvas
            imagecopyresampled($thumbnail, 
                               $source_gd_image, 
                               $offsetX, $offsetY, 
                               0, 0, 
                               $thumbnailWidth, $thumbnailHeight, 
                               $sourceSizes[0], $sourceSizes[1]);
            
            // save image as jpg
            imagejpeg($thumbnail, $imageName.'.jpg', 90);
            
        }
        else
        {
            $thumbnailHeight = floor($thumbnailWidth*$sourceSizes[1]/$sourceSizes[0]);
            $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
            
            $imageName = $dossier.$filename.'_'.$thumbnailWidth;
            $srcX = 0;
            $srcY = 0;
            
            imagecopyresampled($thumbnail, $source_gd_image, 0, 0, $srcX, $srcY, $thumbnailWidth, $thumbnailHeight, $sourceSizes[0], $sourceSizes[1]);
        
            switch ($ext) {
                case 'gif':
                    imagegif($thumbnail, $imageName.'.gif');
                    break;
                case 'jpeg':
                case 'jpg':
                    imagejpeg($thumbnail, $imageName.'.jpg', 90);
                    break;
                case 'png':
                    imagepng($thumbnail, $imageName.'.png', 0);
                    break;
            }
        }
        
        
    }

	public function delete(){
		$article = new UserModel($_GET['id']);
		$article->delete();
		header('Location: ' . WEBROOT . 'adminuser/index');
	}
}