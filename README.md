Kohana 3.2 CRUD using Formo and ORM
-----------------------------------
As I couldn't find any usable CRUD, I've decided to create my own. It's based on [Formo](https://github.com/bmidget/kohana-formo) and Kohana's ORM.

I've included both HTML+PHP and Haml templates as I'm using [Kohana3-Haml](https://github.com/d4rky-pl/kohana3-haml).
If you wish to create more templates for different template systems, be my guest and create a pull request :)

Requirements
------------

* [Formo](https://github.com/bmidget/kohana-formo)

How to use it
-------------
Everything is pretty much straightforward and uses existing codebase. Rules for form are created using default ORM's rules() method (see [http://kohanaframework.org/3.2/guide/orm/validation](documentation) on how to use it), and additional parameters (like to ignore ID in form) is in formo() method (see Formo's documentation for both [parameters](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/formo.parameters.md) and [how to use them in your model](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/formo.orm.md))

Your most basic controller would probably look something like this:

    <?php
    class Controller_Crud_Products extends Controller_Crud
    {	 
    	protected $_index_fields = array(
		'id',
    		'name'
    	);
    
    	protected $_orm_model = 'product';
    }

And basic model would be:

    <?php
    class Model_Product extends ORM
    {
    	public $_belongs_to = array('category' => array());
    
    	public function formo()
    	{
    		return array
    		(
    			'id' => array
    			(
    				'render' => false
    			),
    		);
    	}
    
    	public function rules()
    	{
    		return array
    		(
    			'name' => array
    			(
    				array('not_empty')
    			),
    		);
    	}
    }

I've also included a sample route in init.php, feel free to copy it to your bootstrap.php and modify it to suit your needs.

Documentation
-------------
No need. No, seriously, everything you'd want is already covered somewhere else.
Good places to start:

* [Formo documentation](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/), most important: [getting started](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/formo.getting-started.md), [ORM](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/formo.orm.md), [parameters](https://github.com/bmidget/kohana-formo/blob/3.2/master/guide/formo/formo.parameters.md), 
* [ORM documentation](http://kohanaframework.org/3.2/guide/orm), most important: [validation](http://kohanaframework.org/3.2/guide/orm/validation)
* lots of API docs because Kohana developers **love** API docs, am I right? ...

Everything configurable is covered in Kohana_Controller_Crud comments.
