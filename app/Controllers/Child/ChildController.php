<?php

namespace App\Controllers\Child;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;

class ChildController extends Controller
{
	public function getChildUp($request, $response)
	{
		return $this->view->render($response, 'child/childup.twig');
	}

	public function postChildUp($request, $response)
	{
		$current = User::where('email', $_SESSION['user'] ?? '');

		$user = User::create([
			'email' => $request->getParam('email'),
			'groupid' => $_SESSION['user'],
			'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
		]);

		//$this->flash->addMessage('info', 'Child added');

		$data = User::where('groupid', $_SESSION['user'])->get();
		$params = array('data' => $data);

		return $this->view->render($response, 'child/childlist.twig', $params);
	}

	public function getChildList($request, $response)
	{
		$data = User::where('groupid', $_SESSION['user'] ?? '')->get();
		$params = array('data' => $data);

		return $this->view->render($response, 'child/childlist.twig', $params);
	}

	public function postChildList($request, $response)
	{
		$email = $this->request->getParam('d');
		$user = User::where('email', $email)->delete();

        $data = User::where('groupid', $_SESSION['user'] ?? '')->get();
		$params = array('data' => $data);

		return $this->view->render($response, 'child/childlist.twig', $params);

	}


}