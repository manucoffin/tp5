<?php

class CommentObserver implements SplObserver{
    public function update(SplSubject $obj) {
        $data = $obj->getData();
        $msg = "Bonjour ".$data['author']['name'].", ".$data['user']->name." a laissé un commentaire sur votre article ".$data['article']->titre.".";
        
        mail($data['author']['email'],$data['user']->name." vous a écrit.",$msg);
    }
}
