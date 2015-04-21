<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
//use Illuminate\Http\Request;
use Request;
use \Illuminate\Support\Facades\Facade; // ???
use Response;
use App\Classes\User;
use App\Classes\Hotel;
use App\Classes\Review;

//require_once('\Classes\class.php');

class SnapReviewController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */


	public function sortByRanking()
	{
		for($i=0; $i<10;$i++)
			{
				$hotels[]= new Hotel((string)$i,"name".$i,"category".$i,"reviewCount".$i,"rating".$i,rand(1, 10),"imageURL".$i,"profileImageURL".$i);
			}


			for($j=0;$j<count($hotels);$j++)
	        {
	            $temp ="";
	            $pos_min=$j;
	            for($i =$j+1;$i<count($hotels);$i++)
	                if($hotels[$pos_min]->ranking >$hotels[$i]->ranking)
	                    $pos_min=$i;
	            if($pos_min!=$j)
	            {
	                $temp=$hotels[$j];
									$hotels[$j]=$hotels[$pos_min];
									$hotels[$pos_min]=$temp;
	            }
	        }

		return $hotels;
	}

	public function getReviews($id)
	{
		for($i=0; $i<5;$i++)
			{
				$userTemp= new User("user".$i,(string)$i,"lastName".$i,"joinDate".$i,"country".$i,"phoneNumber".$i,"username".$i,"email".$i,"profileImageURL".$i);
				$reviews[]= new Review("title".$i,"imageURL".$i,rand(1, 10),"created".$i,"username".$i,"email".$i,"profileImageURL",$i,"created".$i,$userTemp);
			}


		return Response::json($reviews,200);
	}

	public function userById($id)
	{

		for($i=0; $i<10;$i++)
			{
				$users[]= new User("user".$i,(string)$i,"lastName".$i,"joinDate".$i,"country".$i,"phoneNumber".$i,"username".$i,"email".$i,"profileImageURL".$i);
			}

		$errorCode = 0;
		$errorMessage = "id non trovato";
    $presente =  0;




		if(empty($id))
		{
			return  response()->json([
				'code' => $errorCode,
				'message' => $errorMessage
				],
				400);
		}
		else
		{
			for ($i = 0; $i < count($users); $i++)
			{
				if($users[$i]->id == $id)
						{
							$presente = 1;
							$foundPerson = $users[$i];
						}

			}

			if($presente=="1")
				return  response()->json([
					'id' => $foundPerson->id,
					'firstName' => $foundPerson->firstName,
					'lastName' => $foundPerson->lastName,
					'joinDate' => $foundPerson->joinDate,
					'country' => $foundPerson->country,
					'phoneNumber' => $foundPerson->phoneNumber,
					'username' => $foundPerson->username,
					'email' => $foundPerson->email,
					'profileImageURL' => $foundPerson->profileImageURL,
					],
					200);
				else
				return  response()->json([
					'code' => $errorCode,
					'message' => $errorMessage
					],
					410);

				}
	}

	public function create()
    {

			$name = Request::input('name');
			$surname = Request::input('surname');
			$email = Request::input('email');
			$password = Request::input('password');

			$errorCode = 0;
			$errorMessage = "String";

			if(empty($name)||empty($surname)||empty($email)||empty($password))
			{

				return response()->json("",400);
			}
			else
			return Response::json("",201);


    }

    public function recover()
		{
			$errorCode = 0;
			$errorMessage = "String";
			$email = Request::input('email');

			if(empty($email))
				return response()->json(([
																	'code' => $errorCode,
																	'message' => $errorMessage
																 ]),400);
			else
				return response(" ", 200);

		}

		public function login(Request $request)
		{
			$FINAL_USERNAME="paulo";
			$FINAL_PASSWORD= "provapass";
			$token = "un-token-di-risposta";
			$errorCode = 0;
			$errorMessage = "String";


			$username = Request::input('username');
			$password = Request::input('password');


			if( $username==$FINAL_USERNAME && $password==$FINAL_PASSWORD)
				return response($token, 200);
			else
				{
					return response()->json(([
						'code' => $errorCode,
						'message' => $errorMessage
						]),400);

				}
		}

	public function me(Request $request)
	{
		$token = Request::header('Token');
		$userId = "String";
		$firstName = "String";
		$lastName = "String";
		$joinDate = "String";
		$country = "String";
		$phoneNumber = "String";
		$username = "String";
		$email = "String";
		$profileImageURL = "String";
		$errorCode = 0;
		$errorMessage = "String";


		if(empty($token))
			return response()->json((
					[
						'code' => $errorCode,
						'message' => $errorMessage
					]),401);
		else
			{
				return response()->json((
							[
								'userId' => $userId,
								'lastName' => $lastName,
								'joinDate' => $joinDate,
								'country' => $country,
								'phoneNumber' => $phoneNumber,
								'username' => $username,
								'email' => $email,
								'profileImageURL' => $profileImageURL,
							]),200);
			}


		return $token;

	}

	public function test($username)
	{
		return $username;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
