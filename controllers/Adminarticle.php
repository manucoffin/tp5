<?php

/** @todo sécuriser l'administration avec une connexion user */
class AdminArticleController extends Controller{

	public function index(){
        
        $limit = 10;
        if(isset($_GET['page']))
        {
            $articles = ArticleModel::getLimit($limit, $_GET['page']*$limit);
        }
        else
        {
            // if the get variable is not set we want to get the first page
            $articles = ArticleModel::getLimit($limit, 0);
        }
        $allArticles = ArticleModel::getAll();
        
		$this->set(array('articles'=>$articles));
        $this->set(array('allArticles'=>$allArticles));
        $this->set(array('limit'=>$limit));
		$this->render('index');
	}

	public function createedit(){
		//si on a un id en GET, on charge l'article, sinon on charge un article vide pour la création
		$id = isset($_GET['id'])?$_GET['id']:null;
		$article = new ArticleModel($id);
		$activeUsers = UserModel::getAll(true);
		$this->set(array('article'=>$article));
		$this->set(array('users'=>$activeUsers));
        
		$this->render('createedit');
	}

	public function postprocess(){
        session_start();
		//on vérifie si on a bien des donnee POST envoyées
		if(count($_POST)){
			$id = isset($_GET['id'])?$_GET['id']:null;
			$article = new ArticleModel($id);
			$article->titre = $_POST['titre'];
			$article->contenu = $_POST['contenu'];
            
            // Change the author only if we create the article
            if(!$id)
                $article->id_user = $_POST['auteur'];
            
			$article->datetime = date('Y-m-d H:i:s');
			$article->save();
            
            
            if(isset($_FILES['cover'])){
                if($_FILES['cover']['error'] == UPLOAD_ERR_OK)
                {
                    $dossier = ROOT.'/upload/articleCovers/';
                    $fichier = $_FILES['cover']['name'];//ou on peut mettre le nom de fichier que l'on veut pour être certain d'éviter les doublons
                    
                    if(move_uploaded_file($_FILES['cover']['tmp_name'], $dossier.$fichier))
                    {
                        //la fonction renvoie true, le fichier a bien été enregistré
                        $file = 'upload/articleCovers/'.$_FILES['cover']['name'];
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
                            
                            $this->saveImage(800, $dossier, $article->id, $imgsize, $source_gd_image, $ext, $fichier);
                            $this->saveImage(100, $dossier, 'mini_'.$article->id, $imgsize, $source_gd_image, $ext, $fichier);
                            
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
		header('Location: ' . WEBROOT . 'adminarticle/index');
	}
    
    public function saveImage($thumbnailWidth, $dossier, $filename, $sourceSizes, $source_gd_image, $ext, $fichier){
        // create image with the size we want to crop
        // we create a normal cover for the article details
        // and a mini version for the list of articles
        if($thumbnailWidth == 800)
            $thumbnail = imagecreatetruecolor(800, 300);
        else if($thumbnailWidth == 100)
            $thumbnail = imagecreatetruecolor(100, 37);

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


        $imageName = $dossier.$filename.'_cover';

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

	public function delete(){
		$article = new ArticleModel($_GET['id']);
		$article->delete();
		header('Location: ' . WEBROOT . 'adminarticle/index');
	}
    
    public function exportArticlesCSV(){
        
        $articles = ArticleModel::getAllArticlesOnly();
        
        $list = array();
        // set the header of the CSV file
        $list[] = array('id', 'titre', 'contenu', 'date', 'id auteur', 'nb commentaires');
        foreach($articles as $a){
            $comments = CommentaireModel::getAll($a->id);
            $list[] = array($a->id, $a->titre, $a->contenu, $a->datetime, $a->id_user, count($comments));
        }
        
        // Write the CSV file
        $fp = fopen('articles.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        
        // Force the download of the file
        $file = 'articles.csv';

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
            unlink(ROOT.'articles.csv');
            exit;
        }
    }
}