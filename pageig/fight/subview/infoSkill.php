<?php

       $array_infos_skills = $fighter->getAllSkills();
       
       foreach($array_infos_skills as $info_skill)
       {
           //Aucune requête bien sûr chargé avec un array
           $skill = new skill($info_skill);
           
           $skill->getDescription();
       }