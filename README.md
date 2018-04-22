# PHML
Powerful advanced HTML creation system using PHP only.

## About
  * Version: 1.0
  * Author: Paulo Rodriguez (xLaming)

## Functions:
  * PHML::theme('theme')
    * Description: Adds theme for your template
    * Available: bootstrap3, bootstrap4, mdl
    
  * PHML::create('tag name', 'content here', ['style' => 'color: #ffffff;'])
    * Description: Creates attributes in your template
    * Information: Two last args are OPTIONAL

  * PHML::add('tag name', 'content here', ['style' => 'color: #ffffff;'])
    * Description: Creates elements or attributes for your template
    * Information: Two last args are OPTIONAL
    * Return: (string)

  * PHML::customCSS('custom CSS here')
    * Description: Loads custom CSS

  * PHML::customJS('custom JS here')
    * Description: Loads custom JavaScript

  * PHML::loadCSS('link here')
    * Description: Loads external CSS

  * PHML::loadJS('link here')
    * Description: Loads external JavaScript

  * PHML::comment('Hello World') 
    * Description: Comment in the template
    
  * PHML::list('tag name', array(), []) 
    * Description: Generates a string to be used in PHP::create()
    * Information: Two last args are OPTIONAL
    * Return: (string)

  * PHML::array('tag name', array(), [])
    * Description: Generates an array to be used in PHP::create()
    * Information: Two last args are OPTIONAL
    * Return: (array)

  * PHML::minify(true)
    * Description: Set minify true or false

  * PHML::show()
    * Description: Display the template
