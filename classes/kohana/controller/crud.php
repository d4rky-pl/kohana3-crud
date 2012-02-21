<?php
/*
 * CRUD controller usable as a base for administration panel
 * @author Michał Matyas <michal@matyas.pl>
 */
abstract class Epic_Core_Admin_Scaffolder extends Controller
{

	/*
	 * @var $_index_fields ORM fields shown in index
	 */	 
	protected $_index_fields = array(
		'id'
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
	 * CRUD controller: READ
	 *
	 * If you are already using Pagination module, consider using my
	 * Pagination helper to keep it simple (I didn't want to make Pagination required)
	 * @see http://nerdblog.pl/2011/09/01/kohana-3-pagination-helper-using-jelly/
	 */
	public function action_index()
	{
		$elements = ORM::Factory($this->_orm_model)
		               ->find_all();

		return $this->render('index', array('elements' => $elements));
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
			if($this->_create_passed($form, $element))
			{
				$element->save();
				$form->orm('save_rel', $element);

				$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Request::current()->controller())));
			}
		}
		else
		{
			$this->_create_failed($form, $element);
		}

		return $this->render('create', array('form' => $form));
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
			if($this->_update_passed($form, $element))
			{
				$element->save();
				$form->orm('save_rel', $element);

				$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Request::current()->controller())));
			}
		}
		else
		{
			$this->_update_failed($form, $element);
		}

		return $this->render('update', array('form' => $form));
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
				$this->request->redirect(Route::get($this->_route_name)->uri(array('controller'=> Request::current()->controller())));
			}
		}

		return $this->render('delete', array('element' => $element));
	}

	/*
	 * Hooks - they will be here until Formo incorporates callbacks into stable version
	 */

	/*
	 * This method is a hook for form validation in Create action.
	 * It fires when form validation has passed.
	 *
	 * @param Formo_Form $form Formo_Form object
	 * @return mixed
	 */
	protected function _create_passed(Formo_Form $form, ORM $element)
	{
		// You will probably want to extend this method
		return true;
	}

	/*
	 * This method is a hook for form validation in Create action.
	 * It fires when form validation has failed.
	 *
	 * @param Formo_Form $form Formo_Form object
	 * @return mixed
	 */
	protected function _create_failed(Formo_Form $form, ORM $element)
	{
		// You will probably want to extend this method
		return true;
	}

	/*
	 * This method is a hook for form validation in Update action.
	 * It fires when form validation has passed.
	 *
	 * @param Formo_Form $form Formo_Form object
	 * @return mixed
	 */
	protected function _update_passed(Formo_Form $form, ORM $element)
	{
		// You will probably want to extend this method
		return true;
	}

	/*
	 * This method is a hook for form validation in Update action.
	 * It fires when form validation has failed.
	 *
	 * @param Formo_Form $form Formo_Form object
	 * @return mixed
	 */
	protected function _update_failed(Formo_Form $form, ORM $element)
	{
		// You will probably want to extend this method
		return true;
	}

	/*
	 * This method is a wrapper for templating system.
	 *
	 * This allows use of eiter View, Haml, Mustache or any other templating
	 * system you'd like to use.
	 * It defaults to the basic View though.
	 *
	 * @param string $view View name
	 * @param mixed $data View data
	 * @return View
	 */
	protected function render($view = null, $data = null)
	{
		$r = Request::current();
		$custom = ($r->directory() ? $r->directory().'/' : '') . $r->controller() . '/' . $r->action();
		$default = 'crud/'.$view;

		$data = array('fields' => $this->_index_fields, 'name' => $this->_orm_model, 'route' => $this->_route_name) + $data;

		try
		{
			$view = new View($custom, $data);
		}
		catch(Kohana_View_Exception $e)
		{
			$view = new View($default, $data);
		}

		$this->response->body($view);
	}

}
