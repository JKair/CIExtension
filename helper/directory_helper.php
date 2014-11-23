<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Directory Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/directory_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Create a Directory Map
 *
 * Reads the specified directory and builds an array
 * representation of it.  Sub-folders contained with the
 * directory will be mapped as well.
 *
 * @access	public
 * @param	string	path to source
 * @param	int		depth of directories to traverse (0 = fully recursive, 1 = current dir, etc)
 * @return	array
 */
if ( ! function_exists('directory_map'))
{
	function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
	{
		if ($fp = @opendir($source_dir))
		{
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

			while (FALSE !== ($file = readdir($fp)))
			{
				// Remove '.', '..', and hidden files [optional]
				if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
				{
					continue;
				}

				if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
				{
					$filedata[$file] = directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
				}
				else
				{
					$filedata[] = $file;
				}
			}

			closedir($fp);
			return $filedata;
		}

		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * 扩展文件夹遍历文件函数
 *
 * 使CI的文件帮助函数也支持文件便利，从而更方便一次可以获取多个文件的内容
 * 你可以使用以下三种方式去使用这个函数
 * 1.与官方文档一致的使用方式
 * 2.定义一个数组，数组参数的下标为之后返回此次遍历动作的名字，参数为路径
 * 3.定义一个数组，在数组里面再定义一个数组，去设置参数，支持的参数和官方文档一直，遍历路径的下标为“dir”
 * 此函数的官方文档为：http://codeigniter.org.cn/user_guide/helpers/directory_helper.html
 *
 * @access	public
 * @param	$map_dir 			array	文件的路径，支持三种格式  array('The public' => '..','js' => array('dir' => '..','depth' => 2 ));
 * @param	$directory_depth 	int  	定义深度
 * @param 	$hidden 			boolean	是否显示隐藏文件	
 * @return	array
 */

if ( ! function_exists('directory_map_by_array'))
{
	function directory_map_by_array($map_dir, $directory_depth = 1, $hidden = FALSE)
	{
		//support directory_map
		if ( !is_array($map_dir))
		{
			return directory_map($map_dir, $directory_depth, $hidden);
		}

		$return_dir_map = array();

		foreach ($map_dir as $dir_index => $dir_value) 
		{
			//make a array to deal whit the config about the dir need to map
			$dir_map_config = array();
			if ( ! is_array($dir_value))
			{
				$return_dir_map[$dir_index] = directory_map($dir_value, $directory_depth, $hidden);
				continue;
			}
			//return the wrong message if the config wrong
			if ( ! isset($dir_value['dir']))
			{
				$return_dir_map[$dir_index] = 'error:You must set the dir.';
				continue;
			}
			else
			{
				$dir_map_config['dir'] = $dir_value['dir']; 
			}

			//support the default

			if ( ! isset($dir_value['depth']))
			{
				$dir_map_config['depth'] = $directory_depth;
			}
			else
			{
				$dir_map_config['depth'] = $dir_value['depth'];
			}

			if ( ! isset($dir_value['hidden']))
			{
				$dir_map_config['hidden'] = $hidden;
			}
			else
			{
				$dir_map_config['depth'] = $dir_value['hidden'];
			}

			//map the dir
			$return_dir_map[$dir_index] = directory_map($dir_map_config['dir'], $dir_map_config['depth'], $dir_map_config['hidden']);
		}

		return $return_dir_map;
	}
}

/* End of file directory_helper.php */
/* Location: ./system/helpers/directory_helper.php */