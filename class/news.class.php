<?php

class news {

    private $id;
    private $date;
    private $title;
    private $content;

    function news($id = 0) {
        if ($id > 0) {
            /*
              $result = get_cache('news','news_'.$id);
              if (is_bool($result))
              {
             */
            $sql = "SELECT * FROM `news` WHERE id = $id";
            $result = loadSqlResultArray($sql);

            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

// Ascenseur  

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function getDate2() {
        return $this->date;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getTitle() {
        return $this->title;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function getContent() {
        return $this->content;
    }

// Fonctions

    function showNews() {
        echo '<div style="margin-left:10px;">';
        echo ' <u><b>' . $this->getDate2();
        echo ' : ';
        echo $this->getTitle() . ' : </b></u>';
        echo '</div>';

        echo '<div style="margin-top:20px;padding-left:10px;">';
        echo html_entity_decode($this->getContent());
        echo '</div><br />';
    }

// Fonctions static 

    public static function getAllNews() {
        $result2 = get_cache('news', 'news_lastnews');
        if (is_bool($result2)) {
            $sql = "SELECT id FROM `news` ORDER BY `date` DESC,id DESC LIMIT 5 ";
            $result = loadSqlResultArrayList($sql);
            create_cache('news', 'news_lastnews', $result2);
            return $result;
        }
    }
    
    /** Créées un objet News.
     * 
     * @param type $title
     * @param type $content
     * @throws Exception
     */
    public static function addNews($title,$content)
    {
        try 
        {
            
            $sql = "INSERT INTO totototo (date,title,content) VALUES (CURRENT_TIMESTAMP,'" . $title . "','" . $content . "')";

            loadSqlExecute($sql);
            destroy_cache('news', 'news_lastnews');
        }
        catch(Exception $e)
        {
            throw new Exception("Une erreur est survenue lors de l'ajout de la news");
        }
        
    }

}

?>