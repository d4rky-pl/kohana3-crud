<?php
/*
 * CRUD controller usable as a base for administration panel
 * @author Michał Matyas <michal@matyas.pl>
 */
abstract class Kohana_Controller_Crud extends Controller
{

	/*
	 * @var $_index_fields ORM fields shown in index
	 */	 
	protected $_index_fields = array(

	);

	/*
	 * @var $_orm_model ORM model name
	 */
	protected $_orm_model = '';

	/*
	 * @var $_route_name Route to be used for actions (default: crud)
	 */
	protected $_route_name = 'crud';

	/*
	 * @var $_template Template to use (default: html)
	 */
	protected $_template = 'html';

	/*
	 * @var $_template_driver Template driver to use (default: View)
	 */
	protected static $_template_driver = 'View';

	/*
	 * CRUD controller: READ
	 */
	public function action_index()
	{
		$elements = ORM::Factory($this->_orm_model)
		               ->find_all();

		$this->response->body(self::View('crud/'.$this->_template.'/index')
		     ->set(array('name' => $this->_orm_model,
		                  'elements' => $elements,
		                  'fields' => $this->_index_fields,
		                  'route' => $this->_route_name))
		);
	}
	
	/*
	 * CRUD controller: CREATE
	 */
	public function action_create()
	{
		$element = ORM::Factory($this->_orm_model);
		
		$form = Formo::form()->orm('load',$element);
		$form->add('save', 'submit', 'Create');
		
		if($form->load($_POST)->validate())
		{
			$element->save();
			$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Inflector::plural($this->_orm_model))));
		}

		$this->response->body(self::View('crud/'.$this->_template.'/create')
		     ->set(array('name' => $this->_orm_model,
		                 'form' => $form,
		                 'route' => $this->_route_name))
		);
	}
	
	/*
	 * CRUD controller: UPDATE
	 */
	public function action_update()
	{
		$element = ORM::Factory($this->_orm_model, $_GET['id']);
		
		$form = Formo::form()->orm('load',$element);
		$form->add('update', 'submit', 'Save');
		
		if($form->load($_POST)->validate())
		{
			$element->save();
			$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Inflector::plural($this->_orm_model))));
		}

		$this->response->body(self::View('crud/'.$this->_template.'/update')
		     ->set(array('name' => $this->_orm_model,
		                  'form' => $form,
		                  'route' => $this->_route_name))
		);
	}
	/*
	 * CRUD controller: DELETE
	 */
	public function action_delete()
	{
		$element = ORM::Factory($this->_orm_model, $_GET['id']);

		if($_POST)
		{
			if($_POST['id'] == $element->id)
			{
				$element->delete();
				$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Inflector::plural($this->_orm_model))));
			}
		}

		$this->response->body(self::View('crud/'.$this->_template.'/delete')
		     ->set(array('name' => $this->_orm_model,
		                  'element' => $element,
		                  'route' => $this->_route_name))
		);
	}

	protected static function View($filename = null, $data = null)
	{
		return new self::$_template_driver($filename, $data);
	}
}
