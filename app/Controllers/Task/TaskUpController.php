<?php

namespace App\Controllers\Task;

use App\Models\User;
use App\Models\Task;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class TaskUpController extends Controller
{

	public function getTaskUp($request, $response)
	{
		$data = $request->getParam('email');
		$params = array('data' => $data);
		return $this->view->render($response, 'task/taskup.twig', $params);
	}

	public function postTaskUp($request, $response)
	{
		$task = Task::create([
			'email' => $request->getParam('email'),
			'groupid' => $_SESSION['user'],
			'description' => $request->getParam('description'),
			'start' => $request->getParam('start'),
			'end' => $request->getParam('end'),
		]);

		$email = $this->request->getParam('email');
		$data = Task::where('email', $email)->get();
		$params = array('data' => $data, 'email' => $email);

		return $this->view->render($response, 'task/taskslist.twig', $params);
	}
}