<?php
/**
 * MIT License. Copyright (c) 2018 Paulo Rodriguez
 * PHML - PHPHTML is a project that allows you to make html codes
 * using PHP only, it is useful to people who like the codes clean
 * without lots of html mixed with php, with PHML you can do it all
 * using PHP only, all for free for personal and commercial.
 *
 * @author Paulo Rodriguez (xLaming)
 * @link https://github.com/xlaming/phml
 * @version 1.0
 */
class PHML
{
	/**
	 * Store all content to display later
	 *
	 * @var string
	 */
	public $content;

	/**
	 * General settings - do not touch if you dont know
	 *
	 * @var array
	 */
	private $settings = [
		'minify'   => false,
		'charset'  => 'UTF-8',
		'viewport' => 'width=device-width, initial-scale=1.0'
	];

	/**
	 * Theme settings
	 *
	 * @var array
	 */
	protected $themes = [
		'bootstrap3' => [ // theme Bootstrap 3
			'css' => [
				'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
			],
			'js'  => [
				'//code.jquery.com/jquery-3.3.1.min.js',
				'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
			]
		],
		'bootstrap4' => [ // theme Bootstrap 4
			'css' => [
				'//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
			],
			'js'  => [
				'//code.jquery.com/jquery-3.3.1.min.js',
				'//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'
			]
		],
		'mdl' => [ // theme Material
			'css' => [
				'//fonts.googleapis.com/icon?family=Material+Icons',
				'//code.getmdl.io/1.3.0/material.indigo-pink.min.css'
			],
			'js'  => [
				'//code.jquery.com/jquery-3.3.1.min.js',
				'//code.getmdl.io/1.3.0/material.min.js'
			]
		],
	];

	/**
	 * Constructor method
	 *
	 * @param string $name   Page name (REQUIRED)
	 * @param string $desc   Page description (OPTIONAL)
	 * @param string $keys   Page keywords (OPTIONAL)
	 * @param string $author Page author (OPTIONAL)
	 */
	public function __construct($name, $desc = null, $keys = null, $author = null)
	{
		try
		{
			if (empty($name))
			{
				throw new Exception('Name cannot be empty');
			}
			
			$this->create('title', $name);
			$this->create('meta', null, ['charset' => $this->settings['charset']]);
			$this->create('meta', null, ['name' => 'viewport', 'content' => $this->settings['viewport']]);
			
			if (!is_null($desc))
			{
				$this->create('meta', null, ['name' => 'description', 'content' => $desc]);
			}
			if (!is_null($author))
			{
				$this->create('meta', null, ['name' => 'author', 'content' => $author]);
			}
			if (is_array($keys))
			{
				$this->create('meta', null, ['name' => 'keywords', 'content' => implode(',', $keys)]);
			}
		}
		catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	/**
	 * Minify the page, it can improve the loading time
	 *
	 * @param  bool $value
	 * @return bool
	 */
	public function minify($value)
	{
		$this->settings['minify'] = (bool) $value;
		return true;
	}

	/**
	 * Add your custom CSS to the template
	 *
	 * @param  string $value CSS content
	 * @return mixed
	 */
	public function customCSS($value)
	{
		if (empty($value))
		{
			return false;
		}
		
		$this->create('style', $value);
	}

	/**
	 * Add your custom JavaScript to the template
	 *
	 * @param  string $value JavaScript content
	 * @return bool
	 */
	public function customJS($value)
	{
		if (empty($value))
		{
			return false;
		}
		
		$this->create('script', $value);
	}

	/**
	 * Load external CSS library
	 *
	 * @param  string $value Library link
	 * @return bool
	 */
	public function loadCSS($value)
	{
		if (empty($value))
		{
			return false;
		}
		
		$this->create('link', chr(32), ['rel' => 'stylesheet', 'type' => 'text/css', 'href' => $value]);
	}

	/**
	 * Load external CSS library
	 *
	 * @param  string $value Library link
	 * @return bool
	 */
	public function loadJS($value)
	{
		if (empty($value))
		{
			return false;
		}
		
		$this->create('script', chr(32), ['src' => $value]);
	}

	/**
	 * Load a custom template pre-defined
	 *
	 * @param  string $value Template name
	 * @return bool
	 */
	public function theme($value)
	{
		if (empty($value))
		{
			return false;
		}
		
		$theme = strtolower($value);
		
		if(empty($this->themes[$theme]))
		{
			return false;
		}
		
		foreach ($this->themes[$theme] as $k => $v)
		{
			foreach ($v as $y)
			{
				if ($k == 'css')
				{
					$this->loadCSS($y);
				}
				else if ($k == 'js')
				{
					$this->loadJS($y);
				}
			}
		}
	}

	/**
	 * Add comentaries to the HTML
	 *
	 * @param  string $content Comment
	 * @return bool
	 */
	public function comment($content)
	{
		if (empty($content))
		{
			return false;
		}
		
		$result = "<!--{$content}-->";
		$this->content .= $result;
	}

	/**
	 * Creating a element and automatically adding it to the template
	 *
	 * @param  string $attr     Attribute name (REQUIRED)
	 * @param  string $content  Content inside the attribute (OPTIONAL)
	 * @param  array $elements Elements (OPTIONAL)
	 */
	public function create($attr, $content = null, $elements = null)
	{
		$attributes = null;
		
		if (is_array($elements))
		{
			foreach ($elements as $k => $y)
			{
				if (is_array($y))
				{
					foreach ($y as $z)
					{
						$attributes .= " {$k}=\"{$z}\"";
						break;
					}
				}
				else
				{
					$attributes .= " {$k}=\"{$y}\"";
				}
			}
		}
		
		if (empty($content))
		{
			$result = "<{$attr}{$attributes}>";
		}
		else
		{
			$result = "<{$attr}{$attributes}>{$content}</{$attr}>";
		}
		$this->content .= $result;
	}

	/**
	 * Creating a element and returning the content as string to be used later
	 *
	 * @param  string $attr     Attribute name (REQUIRED)
	 * @param  string $content  Content inside the attribute (OPTIONAL)
	 * @param  array $elements Elements (OPTIONAL)
	 * @return string
	 */
	public function add($attr, $content = null, $elements = null)
	{
		$attributes = null;
		
		if (is_array($elements))
		{
			foreach ($elements as $k => $y)
			{
				if (is_array($y))
				{
					foreach ($y as $z)
					{
						$attributes .= " {$k}=\"{$z}\"";
						break;
					}
				}
				else
				{
					$attributes .= " {$k}=\"{$y}\"";
				}
			}
		}
		
		if (empty($content))
		{
			$result = "<{$attr}{$attributes}>";
		}
		else
		{
			$result = "<{$attr}{$attributes}>{$content}</{$attr}>";
		}
		return $result;
	}

	/**
	 * Display all the content
	 */
	public function show()
	{
		ob_start();
		print $this->parseToHtml($this->content);
		ob_get_flush();
	}

	/**
	 * Generating content by array, it will return as string
	 *
	 * @param  string $attr     Attribute name (REQUIRED)
	 * @param  array $array    Array values (REQUIRED)
	 * @param  array $elements Elements (OPTIONAL)
	 * @return string
	 */
	public function list($attr, $array, $elements = null)
	{
		if (!is_array($array))
		{
			return false;
		}
		
		$result = null;
		
		foreach ($array as $i => $v)
		{
			$attributes = null;
			if (is_array($elements))
			{
				foreach ($elements as $k => $y)
				{
					if (is_array($y))
					{
						$attributes .= " {$k}=\"{$y[$i]}\"";
					}
					else
					{
						$attributes .= " {$k}=\"{$y}\"";
					}
				}
			}
			$result .= "<{$attr}{$attributes}>{$v}</{$attr}>";
		}
		return $result;
	}

	/**
	 * Generating content by array, it will return as array
	 *
	 * @param  string $attr     Attribute name (REQUIRED)
	 * @param  array $array    Array values (REQUIRED)
	 * @param  array $elements Elements (OPTIONAL)
	 * @return array
	 */
	public function array($attr, $array, $elements = null)
	{
		if (!is_array($array))
		{
			return false;
		}
		
		$result = null;
		
		foreach ($array as $i => $v)
		{
			$attributes = null;
			if (is_array($elements))
			{
				foreach ($elements as $k => $y)
				{
					if (is_array($y))
					{
						$attributes .= " {$k}=\"{$y[$i]}\"";
					}
					else
					{
						$attributes .= " {$k}=\"{$y}\"";
					}
				}
			}
			$result[] = "<{$attr}{$attributes}>{$v}</{$attr}>";
		}
		return $result;
	}

	/**
	 * Parse all the HTML to make it clean and working fine
	 *
	 * @param  string $content HTML content
	 * @return mixed
	 */
	private function parseToHtml($content)
	{
		$dom = new DOMDocument();
		
		if (libxml_use_internal_errors(true) === true)
		{
			libxml_clear_errors();
		}
		
		$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
		$content = preg_replace(
			[
				'~\R~u',
				'~>[[:space:]]++<~m'
			],
			[
				"\n",
				'><'
			],
		$content);
		
		if ((empty($content) !== true) && ($dom->loadHTML($content) === true))
		{
			$dom->formatOutput = !$this->settings['minify'];
			if (($content = $dom->saveXML($dom->documentElement, LIBXML_NOEMPTYTAG)) !== false)
			{
				$regex = [
					'~' . preg_quote('<![CDATA[', '~') . '~' => '',
					'~' . preg_quote(']]>', '~') . '~' => '',
					'~></(?:area|base(?:font)?|br|col|command|embed|frame|hr|img|input|keygen|link|meta|param|source|track|wbr)>~' => ' />'
				];
				return '<!DOCTYPE html>' . ($this->settings['minify'] ? "" : "\n") . preg_replace(array_keys($regex), $regex, $content);
			}
		}
		return false;
	}
}
?>
