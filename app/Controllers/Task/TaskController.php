<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class TaskController extends Controller
{
	//Delete task from task list
	public function postTaskList($request, $response)
	{
		$description = $this->request->getParam('d');
		$task = Task::where('description', $description)->delete();

       	$email = $this->request->getParam('email');
		$data = Task::where('email', $email)->get();
		$params = array('data' => $data, 'email' => $email);

		return $this->view->render($response, 'task/taskslist.twig', $params);
	}
}