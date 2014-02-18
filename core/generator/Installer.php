<?php

/**
 * This Script will install the Framework and Set the specific Namespace in each file
 * @author James Schüpbach
 * @version 1.1
 */
 
 class Installer
 {
 	 /**
	  * Regex pattern for the core files
	  * @var string
	  */ 
 	 private static $regexNamespacePattern = "!(namespace\\ )(Core)!";
	 
	 /**
	  * Regex replace pattern for the Core files
	  * @var strings
	  */
	 private static $regexNamespaceReplacePattern = "";
	 
	 /**
	  * Regex pattern for the qualified Core Classes
	  * @var string
	  */
	 private static $regexQualifiedCNames = "!(\\\\Core\\\\)([A-Za-z])!";
	 
	 /**
	  * Regex replace pattern for the qualified Core Classes
	  * @var string
	  */
	 private static $regexQualifiedCNamesReplace ="";
	
	 /**
	  * Regex pattern for the app files
	  * @var string
	  */
	 private static $regexAppNamespacePattern = "!(namespace\\ )(App)!";
	 
	 /**
	  * Regex replace pattern for the app files
	  * @var string
	  */
	 private static $regexAppNamespaceReplacePattern ="";
	 
	 /**
	  * Regex pattern for the qualified App Classes
	  * @var string
	  */
	 private static $regexQualifiedAppNames ="!(\\\\App\\\\)([A-Za-z])!";
	 
	 
	 /**
	  * Regex pattern for the qualified App Classes in a String
	  * @var string
	  */
	 private static $regexQualifiedAppNamesS = "!(\\\\\\\\App\\\\\\\\)+!";
	 
	 /**
	  * Regex remove pattern the the qualified App classe in a String
	  */
	 private static $regexQualifiedAppNamesReplaceS  ="";
	 
	 /**
	  * Regex replace pattern for the qualified App Classes
	  * @var string
	  */
	 private static $regexQaulifiedAppNamesReplace = "";
	
	/**
	 * This static method will install the Framework with an unique namespace
	 * @param array
	 */
 	public static function install($options)
	{
		if(!isset($options[0]) || $options[0] != "core/generator/Installer.php")
		{
			echo "You must call the Installer from the Pluginroot directory";
			exit;
		}
		
		if(!isset($options[1]) || !preg_match("!^[A-Z][A-Za-z]+$!", $options[1]))
		{
			echo "Invalid Classname\n";
			exit;
		}
		if(is_file("core/generator/installLockfile"))
		{
			echo "Can't Install the Framework twice\n";
			exit;
		}
		self::$regexNamespaceReplacePattern ="$1".$options[1]."\\";
		
		

		$directoryIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("./"));
		self::replaceAll($directoryIterator,$options);
	
		
		self::generateInstallLockFile();
		
		
		echo "Installation was successful\n";
	}
	/**
	 * Generates a Lock file, that the install script cant run twice
	 */
	private static function generateInstallLockFile()
	{
		file_put_contents("core/generator/installLockFile","");
	} 
	/**
	 * this method get the content of a specific file
	 * @param string
	 * @return string
	 */
	private static function getFileContent($filename)
	{
		return file_get_contents($filename);
	}
	
	/**
	 * This Method replace all necessary pattern in the specific folder
	 * @param object
	 * @param array
	 * 
	 */
	 private static function replaceAll(RecursiveIteratorIterator $iterator,$options)
	 {
	 			
		foreach($iterator as $filename => $pathObject)
		{
			
			/*
			 * Get all Data
			 * - only check php and template files
			 */
			if(preg_match("!(^.+\.php$)|(^.+\.tmpl$)!",$filename))
			{
				
				if(preg_match("!(^.+Installer\.php$)|(^.+Generator\.php$)!",$filename))
					continue;
				echo $filename; 
				$data = self::getFileContent($filename);
			
				$matches = array();
				preg_match(self::$regexNamespacePattern,$data,$matches);
				
				$qualiMatches = array();
				preg_match(self::$regexQualifiedCNames,$data,$qualiMatches);
				
				$appMatches = array();
				
				preg_match(self::$regexAppNamespacePattern,$data,$appMatches);
			
				
				$appQualiMatches = array();
				preg_match(self::$regexQualifiedAppNames,$data,$appQualiMatches);
				
				
				$appQualiMatchesS = array();
				preg_match(self::$regexQualifiedAppNamesS,$data,$appQualiMatchesS);
				/*
				 * Replace only if it has a match
				 */
				if(count($appQualiMatchesS))
				{
					
					self::$regexQualifiedAppNamesReplaceS = "\\\\\\".$options[1]."\\\\".$appQualiMatchesS[0]."\\";
					$data = preg_replace(self::$regexQualifiedAppNamesS, self::$regexQualifiedAppNamesReplaceS, $data);	
				}
				
				if(count($qualiMatches))
				{
					
					
					self::$regexQualifiedCNamesReplace = "\\".$options[1]."$1$2";
					$data = preg_replace(self::$regexQualifiedCNames, self::$regexQualifiedCNamesReplace, $data);
				}
				if(count($appQualiMatches))
				{
					self::$regexQaulifiedAppNamesReplace = "\\".$options[1]."$1$2";
					$data = preg_replace(self::$regexQualifiedAppNames, self::$regexQualifiedCNamesReplace, $data);	
				}
				if(count($matches))
				{
					self::$regexNamespaceReplacePattern ="$1".$options[1]."\\".$matches[2];
					$data = preg_replace(self::$regexNamespacePattern, self::$regexNamespaceReplacePattern, $data);
				}
				if(count($appMatches))
				{
					
					self::$regexAppNamespaceReplacePattern ="$1".$options[1]."\\".$appMatches[2];
					$data = preg_replace(self::$regexAppNamespacePattern, self::$regexAppNamespaceReplacePattern, $data);
				}
				
				file_put_contents($filename, $data);

				echo "----> installation done\n";	
			}
			
			
		}
	 }
	
 }
Installer::install($argv);
