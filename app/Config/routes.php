<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
//Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
//Router::connect('/base', array('controller' => 'base', 'action' => 'index'));

Router::connect('/', array('controller' => 'home', 'action' => 'index'));
//Router::connect('/bases', array('controller' => 'bases', 'action' => 'add'));

Router::connect('/admin', array('controller' => 'admin', 'action' => 'index', 'admin' => true));
Router::connect('/recruiter', array('controller' => 'recruiter', 'action' => 'index'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => ''));
Router::connect('/pub/*', array('controller' => 'publices', 'action' => 'index'));
Router::connect('/company/page/*', array('controller' => 'publices', 'action' => 'company_page'));
//Router::connect('/jobs/*', array('controller' => 'publices', 'action' => 'job_details'));
//Router::parseExtensions('rss', 'json', 'xml', 'pdf'); // <-- add pdf somewhere in parseExtensions
Router::parseExtensions('pdf');

Router::connect('/the-company/', array('controller' => 'company', 'action' => 'display'));
Router::connect('/the-company/aboutus/', array('controller' => 'company', 'action' => 'aboutus'));


Router::connect('/the-company/why/', array('controller' => 'company', 'action' => 'why'));
Router::connect('/the-company/what/', array('controller' => 'company', 'action' => 'what'));
Router::connect('/the-company/team/', array('controller' => 'company', 'action' => 'team'));
Router::connect('/the-company/joinus/', array('controller' => 'company', 'action' => 'joinus'));
Router::connect('/the-company/contactus/', array('controller' => 'company', 'action' => 'contactus'));
Router::connect('/the-company/members/*', array('controller' => 'company', 'action' => 'members'));
Router::connect('/the-company/test/', array('controller' => 'company', 'action' => 'test'));
Router::connect('/the-company/forgot_password/', array('controller' => 'company', 'action' => 'forgot_password'));
Router::connect('/the-company/reset_password/', array('controller' => 'company', 'action' => 'reset_password'));
Router::connect('/the-company/recover_password/*', array('controller' => 'company', 'action' => 'recover_password'));
Router::connect('/the-company/password_changed/', array('controller' => 'company', 'action' => 'password_changed'));
Router::connect('/the-company/invalid_account/', array('controller' => 'company', 'action' => 'invalid_account'));
Router::connect('/the-company/migrateUser/', array('controller' => 'company', 'action' => 'migrateUser'));

Router::connect('/the-company/track-record/', array('controller' => 'company', 'action' => 'trackRecord'));
Router::connect('/the-company/executive-search-retained/', array('controller' => 'company', 'action' => 'executiveSearchRetained'));
Router::connect('/the-company/executive-search-contingency/', array('controller' => 'company', 'action' => 'executiveSearchContingency'));
Router::connect('/the-company/profile-assessments/', array('controller' => 'company', 'action' => 'profileAssessment'));
Router::connect('/the-company/hr-consultancy-practice/', array('controller' => 'company', 'action' => 'hrConsultancyPractice'));
//Router::connect('/the-company/tauth/', array('controller' => 'company', 'action' => 'twitterAuth'));
Router::connect('/users_messages/view', array('controller' => 'connections', 'action' => 'view'));


/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
