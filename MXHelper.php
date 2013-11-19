<?php
/**
 * A class to provide general helper functions in whole application context
 *
 * @version 1.0a
 * @copyright Richard Jung & Chris Gatner Maxxxor GbR
 * @author Richard Jung <r.jung@jungit.com> 
 * @package components.MXHelper
 */
class MXHelper {
	
	/**
	 * Returns the path to the correct css folder in active theme. 
	 * A file can be defined to get the direct path to this file.
	 * @example $main_css_path = MXHelpers::themeCssPath('main.css');
	 * @param string $file The file to link to directly
	 * @return The path to the theme css folder or the direct file
	 */
	public static function themeCssPath($file = null)
	{

		$path = Yii::app()->baseUrl.'/css/'.Yii::app()->theme->name;

		if ($file !== null) {

			return $path.'/'.$file;
		}

		return $path;
	}

	/**
	 * Return the path of the image folder combined with the given file path.
	 * A sub_path can be defined to add modify the image base path
	 * @param string $file The file name or path
	 * @param string $sub_path The sub path
	 * @return The path to the image
	 */
	public static function resImg($file, $sub_path = false)
	{
		$path = Yii::app()->baseUrl.'/images';

		if ($sub_path !== false) {

			$path.= '/'.$sub_path;
		}

		return $path.'/'.$file;
	}

	public static function ensureRecursiveWritableFolder($folder)
	{
		if (!file_exists($folder)) {

			if (!mkdir($folder, 0777, true)) {

				return true;
			}
		}

		return false;
	}

	public static function buildLinkToRoute($route, $params)
	{
		$link = Yii::app()->urlManager->createUrl($route, $params);

		return (self::isHTTPS()? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$link;
	}

	/**
	 * Return wether the request is taken through https. Knowns about load balancers.
	 * @return boolean True if https is used, false if not
	 */
	public static function isHTTPS()
	{		
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {

		   	return true;
		}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {

			return true;
		}

		return false;
	}

	/**
	 * Return the path of the image folder combined with the given file path and the current theme.
	 * A sub_path can be defined to add modify the image base path
	 * @param string $file The file name or path
	 * @return The path to the image
	 */
	public static function resImgTheme($file)
	{
		return self::resImg($file, Yii::app()->theme->name);
	}

	/**
	 * Returns the base url for resources
	 * @return string The base url for resources
	 */
	public static function resBaseUrl()
	{
		$baseUrl = Yii::app()->params['res']['baseUrl'];

		if ($baseUrl === 'auto') {

			$baseUrl = Yii::app()->baseUrl;
		}

		return $baseUrl;
	}

	/**
	 * Provides the possibility to use open layer
	 */
	public static function provideOpenLayer()
	{
		$cs = Yii::app()->clientScript;
		$am = Yii::app()->getAssetManager();
		$path = $am->publish(Yii::getPathOfAlias('ext.OpenLayers'));

		$cs->registerScriptFile($path.'/OpenLayers.js');
	}
}


?>