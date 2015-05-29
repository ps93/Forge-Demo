<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

                ///////////////////////////
                //////// GET/ME //////////
                /////////////////////////
              /*
              GET: /me
              Required HTTP Header : token

              RESPONSE:
              Success:
              Status Code: 200
              Content-Type: application/json
              Body:
                {
                      "userId": "String",
                     "firstName": "String",
                    "lastName": "String",
                    "joinDate": "String yyyy/MM/dd",
                    "country": "String",
                    "phoneNumber": "String",
                    "username": "String",
                    "email": "String",
                    "profileImageURL": "String"
                  }
              Failure:
              Status Code: 401
              Content-Type = application/json
              Body:
                {
                  "code" = ErrorCode,
                  "message" = "String",
                }

              */
  Route::get('me','SnapReviewController@me'); // passando token ( per ora il token e' l'id es: 1 , 2 ecc)




                  ///////////////////////////
                  //////// PUT/ME //////////
                  /////////////////////////

              /*        {
                    	"userId": "String",
                    	"firstName": "String",
                    	"lastName": "String",
                    	"joinDate": "String yyyy/MM/dd",
                    	"country":
                    		{
                    			"id": "String",
                    			"name": "String"
                    		},
                    	"phoneNumber": "String",
                    	"username": "String",
                    	"email": "String",
                    	"profileImageURL": "provaimageurl"
                    }

                                      RESPONSE:
                  	Success:
                  		Status Code: 200
                  	Failure:
                  		Status Code: 400
                  		Body:
                  		 {
                  		 	"code" = ErrorCode,
                  			"message" = "String",
                  		 }

                      */


  Route::put('me','SnapReviewController@modify'); // serve modificare i miei dati


              /////////////////////////////////
              // GET/business/{id?}/reviews'///
              /////////////////////////

          /*     GET: /businesses/:id/reviews?start=&count=

                          RESPONSE:
                          {
                          	"__metadata":
                          	{
                          		"count": Number,
                          	}

                          	"data":
                          		[
                          			{
                          				"id": "String"
                          				"title": "String",
                          				"coverImageURL": "String",
                              			"rating": Number,
                          				"created": "String yyyy/MM/dd HH:mm",
                          				"user":
                          					{
                             		 				"id": "String",
                          						"username": "String",
                          			    		"profileImageURL": "String"
                              				},
                              		},
                          			...
                          		]
                          }

                */

 Route::get('/business/{id?}/reviews', 'SnapReviewController@getReviews');  //passando lid di business , start e count



                 /////////////////////////////////
                 // GET/business/{id?}/reviews'///
                /////////////////////////////////


                  /*  CREATE USER:
                    -----------
                    POST: /user
                     Content-Type: application/json
                     Body:
                         {
                           "name": "String",
                           "username": "String",
                           "email" : "String",
                           "password: "String",
                         }

                    RESPONSE:
                     Success:
                         Status Code: 201

                     Failure:
                         Status Code: 400
                         Content-Type = application/json
                         Body:
                           {
                             "code" = ErrorCode,
                             "message" = "String",
                           }
                    */


 Route::post('user','SnapReviewController@create');


         ///////////////////////////////////////////
         // GET/  /me/notifications?start=&count=///
        /////////////////////////////////////////

      /*     GET: /me/notifications?start=&count=
          RESPONSE:
          {
          "__metadata":
          {
            "count": Number,
          }
          "data":
          [
            {
              "id": "String",
              "from": "String",
              "message": "String",
              "timestamp": Date,
            }
          ]
        }*/

        Route::get('/me/notifications','SnapReviewController@notifications'); // con start e count



        /////////////////////////////////
        // GET/me/notifications/:id///
        /////////////////////////

/*
        DELETE: /me/notifications/:id
        RESPONSE:
	       Success:
		       Status Code: 200
	      Failure:
		      Status Code: 400
		      Body:
      		 {
      		 	"code" = ErrorCode,
      			"message" = "String",
          }*/


     Route::get('me/notifications/{id?}', 'SnapReviewController@deleteNotif'); //delete in base all'id





 Route::get('/business/search/findAllSortedByRanking', 'SnapReviewController@sortByRanking');

Route::get('/security/authenticate','SnapReviewController@login');
Route::get('/security/recoverPassword','SnapReviewController@recover');

Route::get('user/{id?}', 'SnapReviewController@userById');



Route::get('/me/notifications/all', 'SnapReviewController@deleteNotifAll');

Route::get('/me/favourites', 'SnapReviewController@myFavourites');












//Route::get('security/authenticate/','SnapReviewController@prova');
