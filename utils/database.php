<?php
$site=$_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
        
        if(($site == "127.0.0.1" || $site == "localhost"))
	{
		$server=$_SERVER["DOCUMENT_ROOT"].'/arelidon/';
	}
        else{
	}
        
require_once($server.'class/PDO2.class.php');

function loadSqlExecute($sql,$type=0)
{		
	$connexion=PDO2::connect();
	$connexion->loadSqlExecute($sql);	
} 

function loadSqlResult($sql,$type=0)
{

	$connexion=PDO2::connect();
	$result=$connexion->loadSqlResult($sql);
	
	return $result[0];
}

function loadSqlResultArray($sql,$type=0)
{
	$connexion=PDO2::connect();
	$result=$connexion->loadSqlResultArray($sql);
        
        if(!is_array($result)) $result = array();
	return $result; 
}

function loadSqlResultArrayList($sql,$type=0)
{
	$connexion=PDO2::connect();
	$result=$connexion->loadSqlResultArrayList($sql);
        
        if(!is_array($result)) $result = array();
	return $result; 
}
 
function loadSqlResultObject($sql)
{
	$do = mysql_query($sql)or die($sql); 
	return $do;
}

function fetch($do){
	$retval= array();
	while($row = mysql_fetch_array($do,MYSQL_ASSOC))
		{
			$retval[] = $row;
		}

		return $retval;	
}

function create_cache($category,$nom_cache, $contenu)
{
			
                // Utilisation de serialize() pour transformer $content en cha�ne de caract�res.
        $contenu = serialize($contenu);

        // �chappement les caract�res sp�ciaux pour pouvoir mettre le tout entre quotes dans le futur fichier.
        $contenu = str_replace('','\\' , $contenu);
        $contenu = str_replace('\'','\'' , $contenu);
        $contenu = str_replace("0",'0' , $contenu);

        // Cr�ation du code PHP � stocker dans le fichier.
        $contenu = '<?php' . "\n\n" . '$cache = unserialize(\'' .  $contenu . '\');' . "\n\n" . '?>';
        
        // �criture du code dans le fichier.
        if (is_file($_SERVER["DOCUMENT_ROOT"].'/cache/test.php')){	
        $fichier = fopen($_SERVER["DOCUMENT_ROOT"].'/cache/'.$category.'/donnees_' . $nom_cache . '.php', 'w+');
       
        $resultat = fwrite($fichier, $contenu);
        fclose($fichier);
        }
        

        // Renvoie true si l'�criture du fichier a r�ussi.
        if(isset($resultat))
        	return $resultat;
			
}

// R�cup�re une variable mise en cache.
function get_cache($category,$nom_cache)
{
        // V�rifie que le fichier de cache existe.
        if ( is_file($_SERVER["DOCUMENT_ROOT"].'/cache/'.$category.'/donnees_' . $nom_cache . '.php') )
        {
                // Le fichier existe, on l'ex�cute puis on retourne le contenu de $cache.
                include($_SERVER["DOCUMENT_ROOT"].'/cache/'.$category.'/donnees_' . $nom_cache . '.php');
                return $cache;
        }
        
        else
        {
                // Le fichier de cache n'existe pas, on retourne false.
                return false;
        }
}

function destroy_cache($category,$nom_cache)
{	
	if ( is_file($_SERVER["DOCUMENT_ROOT"].'/cache/'.$category.'/donnees_' . $nom_cache . '.php') )
        {
                return @unlink($_SERVER["DOCUMENT_ROOT"].'/cache/'.$category.'/donnees_' . $nom_cache . '.php');
        }
      
        
}

 
?>
