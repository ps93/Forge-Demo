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
use App\Classes\Snap;
use App\Classes\Country;
use App\Classes\Location;
use App\Classes\ErrorObject;
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
	public function findNear()
	{

		$lat = Request::input('lat');
		$long = Request::input('long');


			$link = mysqli_connect(self::host,self::user,self::password, self::database);

			$result = mysqli_query($link,"SELECT id,name,shortDescription,address,phone,webPage,latX,longY,rooms,postCode FROM business LIMIT 10");

			while ($row = mysqli_fetch_object($result))
			{

					$row->category = "String";
					$row->ranking =1;
					$row->ranking =1;
					$row->reviewCount =10;
					$row->country = new Country(1,"Italy");
					$row->location = new Location(1,"Prova");
					$businesses[]= $row;

			}


			return response()->json(([
					'__metadata' => count($businesses),
						'data' => $businesses ]),200);

	}


	public function countries()
	{

		$lat = Request::input('lat');
		$long = Request::input('long');


			$link = mysqli_connect(self::host,self::user,self::password, self::database);

			$result = mysqli_query($link,"SELECT id,name FROM country");

			while ($row = mysqli_fetch_object($result))
			{
					$countries[]= $row;

			}


			return response()->json(([
					'__metadata' => count($countries),
						'data' => $countries ]),200);

	}

	public function deleteMe()
	{

		$token = Request::input('token');

		if(!empty($token))
			return response(null, 200);
		else {
			$myError = new ErrorObject("non hai i permessi",400);
			return Response::json($myError,400);
		}

	}


	public function myProfileImage()
	{

		$file = Request::file('photo');
		$token = Request::input('token');

		if (Request::hasFile('photo'))
			return response(null, 200);
		else {
			$myError = new ErrorObject("invalid photo",400);
			return Response::json($myError,400);
		}

	}


	public function query()
	{
		$query = Request::input('query');
		$obj =(object) array();

		if(!empty($query))
			return response()->json($obj,200);
			else {
				$myError = new ErrorObject("invalid query",400);
				return Response::json($myError,400);
			}

	}


	public function businessById($id)
	{

			if(!empty($id))
			{
					$link = mysqli_connect(self::host,self::user,self::password, self::database);

					$result = mysqli_query($link,"SELECT id,name,shortDescription,address,phone,webPage,latX,longY,rooms,postCode FROM business where id=".$id."");

					while ($row = mysqli_fetch_object($result))
					{

							$row->category = "String";
							$row->ranking =1;
							$row->ranking =1;
							$row->reviewCount =10;
							$row->country = new Country(1,"Italy");
							$row->location = new Location(1,"Prova");
							$businesses[]= $row;

					}


					return response()->json( $businesses ,200);

			}
			else {
				$myError = new ErrorObject("invalid query",400);
				return Response::json($myError,400);
			}
		}


		public function myReviews()
		{
			$start = Request::input('start');
			$start = (int)$start;
			$count = Request::input('count');


			if(empty($start)||empty($count)){
				$i=0;
				$count = 20 ;
			}
			else {
				$i=$start;
				$count = $count;
			}

			for($i ; $i<$count+$start; $i++)
				$reviews[]=new Review($i,"title","http://www.boorp.com/sfondi_gratis_desktop_pc/sfondi_gratis/sfondi_paesaggi_mare_montagna/irreale_paesaggio_lacustre.jpg",1,"2015/06/03 10:15");


				return response()->json(([
						'__metadata' => count($reviews),
							'data' => $reviews ]),200);


		}


	public function sortByRanking()
	{
		$start = Request::input('start');
		$start = (int)$start;
		$count = Request::input('count');



		$link = mysqli_connect(self::host,self::user,self::password, self::database);

		if(empty($start)||empty($count))
			$result = mysqli_query($link,"SELECT id,name FROM hotels LIMIT 50");
		else
			$result = mysqli_query($link,"SELECT id,name FROM hotels WHERE hotels.id>".$start." LIMIT ".$count."");

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



  public function myFavourites()
	{

		$start = Request::input('start');
		$start = (int)$start;
		$count = Request::input('count');

		$link = mysqli_connect(self::host,self::user,self::password, self::database);

		if(empty($start)||empty($count) )
			$result = mysqli_query($link,"SELECT id,name,shortDescription,address,phone,webPage,latX,longY,rooms,postCode FROM business LIMIT 10");
		else
			$result = mysqli_query($link,"SELECT id,name,shortDescription,address,phone,webPage,latX,longY,rooms,postCode FROM business WHERE business.id >".$start." LIMIT ".$count."");

		while ($row = mysqli_fetch_object($result))
		{

				$row->category = "String";
				$row->ranking =1;
				$row->ranking =1;
				$row->reviewCount =10;
				$row->country = new Country(1,"Italy");
				$row->location = new Location(1,"Prova");
				$businesses[]= $row;

		}


		return response()->json(([
				'__metadata' => count($businesses),
					'data' => $businesses ]),200);

	}




	public function myFavouritesById($id)
	{

		if(!empty($id))
			return response(null, 200);

		else
		{
			$myError = new ErrorObject("id business invalid",400);
			return Response::json($myError,400);

		}


	}

	public function deleteMyFavouritesById($id)
	{

		if(!empty($id))
			return response(null, 200);

		else
		{
			$myError = new ErrorObject("id business invalid",400);
			return Response::json($myError,400);

		}


	}

	public function deleteMyFavouritesAll()
	{

		if(!empty($id))
			return response(null, 200);

		else
		{
			$myError = new ErrorObject("id business invalid",400);
			return Response::json($myError,400);

		}


	}



		public function invite()
		{

			$email = Request::input('email');

			if(empty($email))
				{
					$myError = new ErrorObject("email invalid",400);
					return Response::json($myError,400);

				}
			else
			return response(null, 200);



		}


		public function validateNumber()
		{

			$number = Request::input('phoneNumber');

			if(empty($number))
				{
					$myError = new ErrorObject("phone number missing",400);
					return Response::json($myError,400);

				}
			else
			{
				if(is_numeric($number))
				return response(null, 200);
				else {
					$myError = new ErrorObject("phone number invalid",400);
					return Response::json($myError,400);
				}
			}

		}

		public function validateCode()
		{

			$code = Request::input('code');

			if(empty($code))
				{
					$myError = new ErrorObject("code missing",400);
					return Response::json($myError,400);

				}
			else
				return response(null, 200);

		}


	public function GetReviewById($id)
		{

				$link = mysqli_connect(self::host,self::user,self::password, self::database);
				$result = mysqli_query($link, "SELECT feedback.title,feedback.timestamp AS created,
																				frontuser.id,frontuser.firstName,frontuser.lastName,
																				frontuser.creationDate,country.name AS country,frontuser.userName,
																				frontuser.email FROM feedback,frontuser,country
																				where frontuser.id = feedback.frontuserId AND
																				country.id=frontuser.countryId AND feedback.id=".$id."");



				while ($row = mysqli_fetch_object($result))
					{
						$userTemp= new User($row->firstName,$row->userName,$row->email,"password");
						$userTemp->id= $row->id;
						$userTemp->lastName =  $row->lastName;
						$userTemp->joinDate = $row->creationDate;
						$userTemp->country = $row->country;
						$userTemp->phoneNumber = "+390346 31044";
						$userTemp->username = $row->userName;
						$reviews= new Review($row->title,"http://images.oyster.com/photos/main-pool-delano-hotel-v196830-w902.jpg",rand(1,50),$row->created,$userTemp);
						$snaps[] = new Snap(5,"http://www.boorp.com/sfondi_gratis_desktop_pc/sfondi_gratis/sfondi_paesaggi_mare_montagna/verde_paesaggio.jpg",2,"category","subcategory");
						$snaps[] = new Snap(6,"http://www.enkivillage.com/s/upload/images/2015/01/ff15b621676dcacc43c73f887f7271b6.jpg",3,"category1","subcategory1");
						$reviews->snaps = $snaps;
					}

					if(count($row>0))
					return response()->json($reviews,200);


		 }




	public function getReviews($id)
	{

		$start = Request::input('start');
		$count = Request::input('count');

		$start = (int)$start;
		$count = (int)$count;


		if(empty($start)||empty($count) )
		{
			{
				$myError = new ErrorObject("dati non validi",400);
				return Response::json($myError,400);

			}
		}
		else
		{

					$link = mysqli_connect(self::host,self::user,self::password, self::database);
					$result = mysqli_query($link, "SELECT feedback.title,feedback.timestamp AS created,
																					frontuser.id,frontuser.firstName,frontuser.lastName,
																					frontuser.creationDate,country.name AS country,frontuser.userName,
																					frontuser.email FROM feedback,frontuser,country
																					 where frontuser.id = feedback.frontuserId AND
																					country.id=frontuser.countryId AND feedback.id >".$start." LIMIT ".$count."");



					while ($row = mysqli_fetch_object($result))
						{
							$userTemp= new User($row->firstName,$row->userName,$row->email,"password");
							$userTemp->id= $row->id;
							$userTemp->lastName =  $row->lastName;
							$userTemp->joinDate = $row->creationDate;
							$userTemp->country = $row->country;
							$userTemp->phoneNumber = "+390346 31044";
							$userTemp->username = $row->userName;
							$reviews[]= new Review($row->title,"http://images.oyster.com/photos/main-pool-delano-hotel-v196830-w902.jpg",rand(1,50),$row->created,$userTemp);

						}


						return response()->json(([
								'__metadata' => count($reviews),
									'data' => $reviews ]),200);
	 }
	}

	public function deleteNotif($id)
	{

		$link = mysqli_connect(self::host,self::user,self::password, self::database);
			$query = "DELETE FROM feedback
				WHERE id=".$id."";



				if ($result = mysqli_query($link, $query ) )
				 return response(null, 200);
			 else
				{
					$myError = new ErrorObject("cancellazione notifica fallita",400);
					return Response::json($myError,400);

				}

	}



	public function deleteNotifAll()
	{

		$link = mysqli_connect(self::host,self::user,self::password, self::database);
			$query = "DELETE * FROM feedback";



				if ($result = mysqli_query($link, $query ) )
				 return response(null, 200);
			 else
				{
					$myError = new ErrorObject("cancellazione notifiche fallita",400);
					return Response::json($myError,400);

				}

	}



	public function notifications()
	{

		$start = Request::input('start');
		$count = Request::input('count');
		$start = (int)$start;
		$count = (int)$count;



		$link = mysqli_connect(self::host,self::user,self::password, self::database);
		$query = "SELECT id,frontuserId, text , timestamp FROM feedback where id >".$start." LIMIT ".$count."";


		if(empty($start)||empty($count) )
		{
			{
				$myError = new ErrorObject("dati non validi",400);
				return Response::json($myError,400);

			}
		}
		else
		{
			$result= mysqli_query($link,$query);
			if($result)
			{


				while($notifications = mysqli_fetch_object($result))
				{
					$array[] = $notifications;
				}


					return response()->json(([
															'__metadata' => count($array),
															'data' => $array
														]));

			}
			else {
				$myError = new ErrorObject("non ci sono notifiche",400);
				return Response::json($myError,400);
			}

		}

	}



	public function modify()
	{

		$userId = Request::input('userId');
		$firstName = Request::input('firstName');
		$lastName = Request::input('lastName');
		$joinDate = Request::input('joinDate');
		$country = Request :: input('country'); //oggetto
		$phoneNumber = request :: input('phoneNumber');
		$username = request :: input('username');
		$email = request :: input('email');
		$profileImageURL = request :: input('profileImageURL');



		if(empty($userId)||empty($firstName)||empty($lastName)||empty($joinDate)
		||empty($country)||empty($phoneNumber)||empty($email)||empty($username)||empty($profileImageURL))

		{
			$myError = new ErrorObject("modifica utente fallito",400);
			return Response::json($myError,400);

		}

		else
			return response(null, 200);



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
				$myError = new ErrorObject("campi incompleti",400);
				return Response::json($myError,400);
			}
			else
			{
				if ($result = mysqli_query($link, "INSERT INTO frontuser(firstName,userName,email,password) VALUES ('".$name."','".$username."','".$email."','".$password."') " ) )
				 return response(null, 201);
				else
				{
					$myError = new ErrorObject("inserimento utente fallito",400);
					return Response::json($myError,400);
				}

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
