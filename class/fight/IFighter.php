<?php

interface IFighter
{
	public function getFighterPictureUrl($face);
	
	public function getSkillAvailableList();
	
	public function getLife();
	
	public function getMana();
}