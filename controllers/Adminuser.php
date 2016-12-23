<?php
/** @todo sécuriser l'administration avec une connexion user */
class AdminUserController extends Controller{

	public function index(){
        $limit = 10;
        
        
        if(isset($_GET['page']))
        {
            $users = UserModel::getLimit($limit, $_GET['page']*$limit);
        }
        else
        {
            // if the get variable is not set we want to get the first page
            $users = UserModel::getLimit($limit, 0);
        }
        $allUsers = UserModel::getAll();

        $this->set(array('allUsers'=>$allUsers));
		$this->set(array('users'=>$users));
        $this->set(array('limit'=>$limit));
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
			// Update password only if it changes
			if($_POST['password']!='')
				$user->password = hash('sha256', $_POST['password']);
            
            // Update status only if it changes
            if(isset($_POST['actif']))
                $user->actif = $_POST['actif'];
            
            // Update rank only if it changes
            if(isset($_POST['admin']))
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
                                                        
                            $this->saveImage(150, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(500, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(800, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(50, $dossier, $id, $imgsize, $source_gd_image, $ext, $fichier);
                            
                            imagedestroy($source_gd_image);
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

        // create image with the size we want to crop
        // here we always want to crop a square because these are profile pictures
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

        $imageName = ($thumbnailWidth == 50)?$dossier.$filename.'_profile':$dossier.$filename.'_'.$thumbnailWidth;

        // copy the image to the final canvas
        imagecopyresampled($thumbnail, 
                           $source_gd_image, 
                           $offsetX, $offsetY, 
                           0, 0, 
                           $thumbnailWidth, $thumbnailHeight, 
                           $sourceSizes[0], $sourceSizes[1]);

        // We always want to save as jpg as it is more convenient for retrieving pictures afterwards
        imagejpeg($thumbnail, $imageName.'.jpg', 90);
            
//        }
//        else
//        {
//            $thumbnailHeight = floor($thumbnailWidth*$sourceSizes[1]/$sourceSizes[0]);
//            $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
//            
//            $imageName = $dossier.$filename.'_'.$thumbnailWidth;
//            $srcX = 0;
//            $srcY = 0;
//            
//            imagecopyresampled($thumbnail, $source_gd_image, 0, 0, $srcX, $srcY, $thumbnailWidth, $thumbnailHeight, $sourceSizes[0], $sourceSizes[1]);
//        
//            switch ($ext) {
//                case 'gif':
//                    imagegif($thumbnail, $imageName.'.gif');
//                    break;
//                case 'jpeg':
//                case 'jpg':
//                    imagejpeg($thumbnail, $imageName.'.jpg', 90);
//                    break;
//                case 'png':
//                    imagepng($thumbnail, $imageName.'.png', 0);
//                    break;
//            }
//        }
    }

	public function delete(){
		$article = new UserModel($_GET['id']);
		$article->delete();
		header('Location: ' . WEBROOT . 'adminuser/index');
	}
    
    public function exportUsersCSV(){
        $users = UserModel::getAll();
        
        $list = array();
        // set the header of the CSV file
        $list[] = array('id', 'nom', 'email', 'mot de passe', 'actif', 'admin', 'nb articles', 'nb commentaires');
        foreach($users as $u){
            $list[] = array($u['id'], $u['name'], $u['email'], $u['password'], $u['actif'], $u['admin'], count($u['articles']), count($u['comments']));
        }
        
        $fp = fopen('users.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        
        // Force the download of the file
        $file = 'users.csv';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            // We delete the file as we don't want to keep it on the server
            unlink(ROOT.'users.csv');
            exit;
        }
    }
}