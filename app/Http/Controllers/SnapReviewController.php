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
use DB;


//require_once('\Classes\class.php');

class SnapReviewController extends Controller {

	const user = "root";
	const host ="localhost";
	const password = "forzainter";
	const database = "snapreview";

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
		$link = mysqli_connect(self::host,self::user,self::password, self::database);

		$result = mysqli_query($link,"SELECT id,name FROM hotels LIMIT 50");

    $ranking = 1;

		while ($row = mysqli_fetch_object($result))
		{
				$hotels[]= new Hotel($row->id,$row->name,"Bed and breakfast",rand(30,150),rand(1,200),$ranking,"https://tourismo.co/wp-content/uploads/2015/03/Ideal-Hotel-for-medical-travel.jpg");
				$ranking++;
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
		$link = mysqli_connect(self::host,self::user,self::password, self::database);
		$result = mysqli_query($link, "SELECT feedback.title,feedback.timestamp AS created,
																		frontuser.id,frontuser.firstName,frontuser.lastName,
																		frontuser.creationDate,country.name AS country,frontuser.userName,
																		frontuser.email FROM feedback,frontuser,country
																		 where frontuser.id = feedback.frontuserId AND
																		country.id=frontuser.countryId");

		while ($row = mysqli_fetch_object($result))
			{
				$userTemp= new User($row->firstName,(string)$row->id,$row->lastName,$row->creationDate,$row->country,"+390346 31044",$row->userName,$row->email,"http://www.boorp.com/sfondi_gratis_desktop_pc/sfondi_gratis/sfondi_paesaggi_mare_montagna/paesaggi_mare_montagna_234.jp");
				$reviews[]= new Review($row->title,"http://images.oyster.com/photos/main-pool-delano-hotel-v196830-w902.jpg",rand(1,50),$row->created,$userTemp);
			}


		return Response::json($reviews,200);
	}



	public function create()
    {
			$link = mysqli_connect(self::host,self::user,self::password, self::database);


			$name = Request::input('name');
			$username = Request::input('username');
			$email = Request::input('email');
			$password = Request::input('password');

			$errorCode = 0;
			$errorMessage = "bad request";

			if(empty($name)||empty($username)||empty($email)||empty($password))
			{

				return response()->json($errorMessage,400);
			}
			else
			{
				if ($result = mysqli_query($link, "INSERT INTO frontuser(firstName,userName,email,password) VALUES ('".$name."','".$username."','".$email."','".$password."') " ) )
				 return Response::json("",201);
				else
				return response()->json($errorMessage,400);

			}

    }

    public function recover()
		{
			$link = mysqli_connect(self::host,self::user,self::password, self::database);

			$errorCode = 0;
			$errorMessage = "String";
			$email = Request::input('email');

			if(empty($email))
				return response()->json(([
																	'code' => $errorCode,
																	'message' => $errorMessage
																 ]),400);
			else
				{
					if ($result = mysqli_query($link, "SELECT email FROM frontuser WHERE email='".$email."'") )
						{
							$num_rows = mysqli_num_rows($result);
							if($num_rows>0)
								return response(" ", 200);
							else
								return response()->json(([
																					'code' => $errorCode,
																					'message' => $errorMessage
																				]),400);

						}
					else
						return response()->json(([
																			'code' => $errorCode,
																			'message' => $errorMessage
																		 ]),400);


				}


		}

		public function me(Request $request)
		{
			$token = Request::header('Token');
			$errorCode = 401;
			$errorMessage = "Unauthorized";


			if(empty($token))
				return response()->json((
						[
							'code' => $errorCode,
							'message' => $errorMessage
						]),401);
			else
				{
					$link = mysqli_connect(self::host,self::user,self::password, self::database);
					if ($result = mysqli_query($link, "SELECT frontuser.id,
																										firstName,
																										lastName,
																										creationDate,
																										country.name,
																										userName,
																										email
																					FROM frontuser,country WHERE frontuser.id=".$token." AND country.id=frontuser.countryId"
						 ))
				    {
							$foundPerson = mysqli_fetch_object($result);
							if($foundPerson)
								return response()->json([
									'id' => $foundPerson->id,
									'firstName' => $foundPerson->firstName,
									'lastName' => $foundPerson->lastName,
									'joinDate' => $foundPerson->creationDate,
									'country' => $foundPerson->name,
									'phoneNumber' => '+390346 31044',
									'username' => $foundPerson->userName,
									'email' => $foundPerson->email,
									'profileImageURL' => 'http://www.boorp.com/sfondi_gratis_desktop_pc/sfondi_gratis/sfondi_paesaggi_mare_montagna/paesaggi_mare_montagna_234.jpg'
									],
									200);
							else
								return  response()->json([
																					'code' => $errorCode,
																					'message' => $errorMessage
																			],401);


						}
					else
						return  response()->json([
																				'code' => $errorCode,
																				'message' => $errorMessage
																		],401);

				}




		}


		public function userById($id)
		{
			$link = mysqli_connect(self::host,self::user,self::password, self::database);

			$errorCodeBadRequest = 400;
			$errorCodeGone = 410;
			$errorMessageBadRequest = "Bad Request";
			$errorMessageGone = "Gone";
	    $presente =  0;


			if(empty($id))
			{
				return  response()->json([
					'code' => $errorCodeBadRequest,
					'message' => $errorMessageBadRequest
					],
					$errorCodeBadRequest);
			}
			else
			{
				if ($result = mysqli_query($link, "SELECT frontuser.id,
																									firstName,
																									lastName,
																									creationDate,
																									country.name,
																									userName,
																									email
																				FROM frontuser,country WHERE frontuser.id=".$id." AND country.id=frontuser.countryId"
					 ))
			    {
						$foundPerson = mysqli_fetch_object($result);
						if($foundPerson)
							return response()->json([
								'id' => $foundPerson->id,
								'firstName' => $foundPerson->firstName,
								'lastName' => $foundPerson->lastName,
								'joinDate' => $foundPerson->creationDate,
								'country' => $foundPerson->name,
								'phoneNumber' => '+390346 31044',
								'username' => $foundPerson->userName,
								'email' => $foundPerson->email,
								'profileImageURL' => 'http://www.boorp.com/sfondi_gratis_desktop_pc/sfondi_gratis/sfondi_paesaggi_mare_montagna/paesaggi_mare_montagna_234.jpg'
								],
								200);
						else
							return  response()->json([
																				'code' => $errorCodeGone,
																				'message' => $errorMessageGone
																		],$errorCodeGone);


					}
				else
					return  response()->json([
																			'code' => $errorCodeGone,
																			'message' => $errorMessageGone
																	],$errorCodeGone);


					}
		}

		public function login(Request $request)
		{
			$username = Request::input('username');
			$password = Request::input('password');
			$token = "un-token-di-risposta";
			$errorCode = 0;
			$errorMessage = "String";
			$FINAL_USERNAME="";
			$FINAL_PASSWORD= "";
			$test="";


			$link = mysqli_connect(self::host,self::user,self::password, self::database);


			if ($result = mysqli_query($link, "SELECT userName,password FROM frontuser WHERE userName='".$username."'") )
		    {
					while ($row = mysqli_fetch_object($result))
					 {
						if($row->userName == $username)
							{
								$FINAL_USERNAME = $row->userName;
								$FINAL_PASSWORD = $row->password;
							}
					 }

					if($FINAL_USERNAME != "")
					  if($FINAL_USERNAME ==$username && $FINAL_PASSWORD == $password )
							return response($token, 200)->header('Content-Type','text/plain');
						else
							return response()->json(([
																					'code' => $errorCode,
																					'message' => $errorMessage
																			]),400);
					else
					return response()->json(([
																			'code' => $errorCode,
																			'message' => $errorMessage
																	]),400);

				}
			else
				return response()->json(([
																	'code' => $errorCode,
																	'message' => $errorMessage
																	]),400);

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
