<?php
require_once('src/class.PHML.php');

/**
 * Settings
 */
$cfg = [
  'title'    => 'MyTitle', // page title - REQUIRED
  'desc'     => 'My simple page', // page description - OPTIONAL
  'keywords' => 'key1,key2,key3', // page keywords - OPTIONAL
  'author'   => 'Paulo' // page author - OPTIONAL
];

/**
 * Initialize
 */
$phml = new PHML($cfg['title'], $cfg['desc'], $cfg['keywords'], $cfg['author']);

/**
 * Set my default theme
 */
$phml->theme('bootstrap3'); // available: bootstrap3, bootstrap4 or mdl

/**
 * Construct params to be used later
 */
$getContent = $phml->list('pre', [1, 2, 3, 4]);
$getList    = $phml->array('a',
  [
    'Github',
    'Twitter'
  ],
  [
    'href' => [
      'https://github.com',
      'https://google.com'
    ]
  ]
);

/**
 * Moving below - lazy method
 */
$phml->create('br');

/**
 * Creating a div
 */
$div2 = null;
$div2 .= $phml->add('h1', 'My div is below:');
$div2 .= $phml->add('strong', 'See my div below...', ['style' => 'color:#999']);
$phml->create('div', $div2, ['align' => 'center']);

/**
 * Creating another div
 */
$div1 = null;
$div1 .= $phml->add('h3', 'My numbers:');
$div1 .= $phml->add('div', $getContent, ['id' => 'myDiv']);
$div1 .= $phml->add('h3', 'My links:');
$div1 .= $phml->add('strong', 'Below you see links...', ['style' => 'color:#999']);
$div1 .= $phml->add('ul', $phml->list('li', $getList));
$phml->create('div', $div1, ['class' => 'container']);

/**
 * Show the content
 */
$phml->show();
?>
