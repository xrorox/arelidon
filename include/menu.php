<table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td background="pictures/titrenavigation_14.jpg" width="155" height="21">
                        <div align="center"><span class="Style1">Identifiants</span></div></td>
                      </tr>
                      <tr>
                        <td><div align="left">
                            <div align="center">
                              <table width="155" border="0" align="center" cellpadding="0" cellspacing="0">
                                <form action="include/connection.php" method="POST">
                                  <tr>
                                    <td colspan="2" height="5"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" name="loginArea" value="login" class="champsTexte" onFocus="if(this.value=='login')this.value='';" style="width:118px"></td>
                                    <td width="35">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><input type="password" name="passwordArea" value="password" class="champsTexte" onFocus="if(this.value=='password')this.value='';" style="width:118px"></td>
                                    <td><div align="center">
                                        <input name="submit" type="submit" class="submit" style="width:30px" value="ok">
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="5"></td>
                                  </tr>
                                </form>
                              </table>
                            </div>
                        </div></td>
                      </tr>
                      <tr>
                        <td style="text-align:center;"><img src="pictures/puce_50.jpg" width="12" height="12" align="absmiddle" alt="">&nbsp;&nbsp;<a href="index.php?page=motdepasse" class="menu1">Mot de passe oubli&eacute; ?</a></td>
                      </tr>
                      <tr>
                        <td height="15"></td>
                      </tr>
                     
                      <tr>
                        <td background="pictures/titrenavigation_14.jpg" width="155" height="21"><div align="center"><span class="Style1">Navigation</span></div></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><table width="170" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="pictures/menunavigation_18.jpg" width="50" height="26" alt=""></td>
                              <td background="pictures/menunavigation_19.jpg" width="120" height="26"><a href="index.php" class="menu1"><strong>ACCUEIL</strong></a></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><table width="170" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="pictures/menunavigation_25.jpg" width="50" height="26" alt=""></td>
                              <td background="pictures/menunavigation_19.jpg" width="120" height="26"><a href="index.php?page=inscription" class="menu1"><strong>INSCRIPTION</strong></a></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><table width="170" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="pictures/menunavigation_28.jpg" width="50" height="26" alt=""></td>
                              <td background="pictures/menunavigation_19.jpg" width="120" height="26"><a href="index.php?page=screenshot" class="menu1"><strong>SCREENSHOT</strong></a></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><table width="170" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="pictures/menunavigation_35.jpg" width="50" height="26" alt=""></td>
                              <td background="pictures/menunavigation_19.jpg" width="120" height="26"><a href="#" class="menu1"><strong>FORUM</strong></a></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><table width="170" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="pictures/menunavigation_43.jpg" width="50" height="26" alt=""></td>
                              <td background="pictures/menunavigation_19.jpg" width="120" height="26"><a href="#" class="menu1"><strong>CONTACTS</strong></a></td>
                            </tr>
                        </table></td>
                      </tr>
                      
                      <tr>
                        <td height="15"></td>
                      </tr>
                      
                      <tr>
                        <td background="pictures/titrenavigation_14.jpg" width="155" height="21"><div align="center"><span class="Style1">Infos</span></div></td>
                      </tr>
                      
                      <tr>
                        <td height="5"></td>
                      </tr>
                      
                      <tr>
                        <td><div style="text-align:center;">
                        	<?php 
							echo getNumberOfRegister(),' inscrits';
                       		?>
                       		</div>
                        </td>
                      </tr>
                      
              		 <tr>
                        <td height="5"></td>
                      </tr>
                      
                      <tr>
                        <td><div style="text-align:center;">
	                        <?php 
	                        $online_players = user::getPlayersOnline();
							echo $online_players.' en ligne';
	                        ?> 
	                        </div>
                        </td>
                      </tr>
                       
                      <tr>
                        <td height="15"></td>
                      </tr>
                      
                      <tr>
                        <td background="pictures/titrenavigation_14.jpg" width="155" height="21"><div align="center"><span class="Style1">Partenaires</span></div></td>
                      </tr>
                      <tr>
                        <td height="5"></td>
                      </tr>
                      <tr>
                        <td><div align="center">
                          <p><img src="pictures/logo_54.jpg" width="91" height="35" alt=""></p>
                          <p><img src="pictures/logo_54.jpg" width="91" height="35" alt=""></p>
                        </div></td>
                      </tr>
                    </table>