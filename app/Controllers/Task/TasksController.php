<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class TasksController extends Controller
{
	//Populate task list
	public function postTasksList($request, $response)
	{
	
		$email = $this->request->getParam('d');
		$data = Task::where('email', $email)->get();
		$params = array('data' => $data, 'email' => $email);

		return $this->view->render($response, 'task/taskslist.twig', $params);
	}
}