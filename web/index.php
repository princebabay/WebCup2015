<?php
require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\Common\Persistence\ObjectManager; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Silex\Provider\FormServiceProvider;

class myObject{
	private $id;
	private $title;
	private $summary;
	private $text;
	private $img;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getSummary(){
		return $this->summary;
	}
	
	public function setSummary($summary){
		$this->summary = $summary;
	}

	public function getText(){
		return $this->text;
	}
	
	public function setText($text){
		$this->text = $text;
	}

	public function getImg(){
		return $this->img;
	}
	
	public function setImg($img){
		$this->img = $img;
	}

}


$app = new Silex\Application();

$app->register(
		new Silex\Provider\TwigServiceProvider(), 
		array( 'twig.path' => __DIR__.'/views', )
	);
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());	
$app->register(
		new Silex\Provider\DoctrineServiceProvider(), 
		array( 
			'db.options' => array( 
				'driver' => 'pdo_mysql', 
				'host' => 'localhost', 
				'dbname' => 'silex', 
				'user' => 'root', 
				'password' => '', 
				'charset' => 'utf8mb4',
			), 
		))
	;

$app['security.firewalls'] = array(
	'secured' => array(
		'pattern' => '^/admin/', 
		'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'), 
		'logout' => array('logout_path' => '/admin/logout'),

	),
);


$app->get('/', 
	function () use ($app) { 
		$myObject = new myObject();
		
		$myObject->setTitle('Titre');
		$myObject->setSummary('Objet');
		$myObject->setText('Description');
		
		$sql = "INSERT INTO object(title, summary, text) values ( ? , ? ,? )"; 
		// $app['db']->executeUpdate($sql, array($myObject->getTitle(), $myObject->getSummary(), $myObject->getText()));
		
		return $app['twig']->render('hello.twig', array('home'=>'true')); 
	})->bind('homepage');
	
//////////////////////////////////

$app->get('/virtual', function () use ($app) { 
		return $app['twig']->render('virtual.twig'); 
	})->bind('virtualpage');

/////////////////////////////////

$app->get('/contact', function () use ($app) { 
		return $app['twig']->render('contact.twig', array('contact'=>'true')); 
	})->bind('contactpage');

$app->get('/search', function () use ($app) { 
		return $app['twig']->render('search.twig', array('search'=>'true')); 
	})->bind('searchpage');

$app->match('/result-search', function(Request $request) use ($app) { 
		$key = $request->get('key');
		$sql = "SELECT * FROM page WHERE title LIKE ? or text LIKE ? ORDER BY title"; 
		$results=$app['db']->fetchAll($sql, array('%'.$key.'%', '%'.$key.'%'));

		
		$arrayObj = [];
		foreach ($results as $value){
			$myObject = new myObject();
			
			$myObject->setId($value['id']);
			$myObject->setTitle($value['title']);
			$myObject->setSummary($value['url']);
			$myObject->setText($value['text']);
			$arrayObj[] = $myObject;
		}		
		
		$keyword = $request->get('keyword');
		$sql = "SELECT * FROM object WHERE title LIKE ? ORDER BY title"; 
		$produits=$app['db']->fetchAll($sql, array('%'.$key.'%'));

		$arrayObjProduit = [];
		foreach ($produits as $value){
			$myObject = new myObject();
			
			$myObject->setId($value['id']);
			$myObject->setTitle($value['title']);
			$myObject->setSummary($value['summary']);
			$myObject->setText($value['text']);
			$myObject->setImg($value['img']);
			$arrayObjProduit[] = $myObject;
		}		
		
		return $app['twig']->render('result-search.twig', array('search'=>'true', 'key'=>$key, 'arrayObj'=>$arrayObj, 
									'arrayObjProduit'=>$arrayObjProduit)); 
	})->bind('resultsearchpage');
	

$app->get('/commande', function (Request $request) use ($app) { 
		return $app['twig']->render('commande.twig', array('commande'=>'true')); 
	})->bind('commandepage');

$app->get('/produits', function (Request $request) use ($app) { 
	$sql = "SELECT * FROM object ORDER BY title"; 
	$results=$app['db']->fetchAll($sql);
	
	$arrayObj = [];
	foreach ($results as $value){
		$myObject = new myObject();
		
		$myObject->setId($value['id']);
		$myObject->setTitle($value['title']);
		$myObject->setSummary($value['summary']);
		$myObject->setText($value['text']);
		$myObject->setImg($value['img']);
		$arrayObj[] = $myObject;
	}
		return $app['twig']->render('produit.twig', array('arrayObj'=>$arrayObj, 'produit'=>true)); 
	})->bind('produitpage');

$app->match('/search', function (Request $request) use ($app){
	$keyword = $request->get('keyword');
	$sql = "SELECT * FROM object WHERE title LIKE ? ORDER BY title"; 
	$results=$app['db']->fetchAll($sql, array('%'.$keyword.'%'));
	
	$arrayObj = [];
	foreach ($results as $value){
		$myObject = new myObject();
		
		$myObject->setId($value['id']);
		$myObject->setTitle($value['title']);
		$myObject->setSummary($value['summary']);
		$myObject->setText($value['text']);
		$myObject->setImg($value['img']);
		$arrayObj[] = $myObject;
	}
	return $app['twig']->render('search.twig', array('search'=>'true', 'results'=>$results, 'keyword'=>$keyword)); 
})
->method('POST');

	
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) { 
	$twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) { 
		// implement whatever logic you need to determine the asset path
		return sprintf('http://localhost/webcup2015/web/views/%s', ltrim($asset, '/')); }));
		return $twig;
	}));


$blogPosts = array( 	
				1 => 
					array( 
						'date' => '2011-03-29', 
						'author' => 'igorw',
						'title' => 'Using Silex', 
						'body' => '...',
					),
				2 =>
					array( 
						'date' => '2011-03-30', 
						'author' => 'hgignore',
						'title' => 'Using Silex 1.2', 
						'body' => '...',
					)
				);

$blog = $app['controllers_factory'];
$blog->get('/', function () { 
	return 'Blog home page'; 
}); 

$forum = $app['controllers_factory'];
$forum->get('/', function(){
	return 'Forum home page';
});

$app->mount('/blog', $blog);
 $app->mount('/forum', $forum);



$app['debug'] = true;
$app->run();