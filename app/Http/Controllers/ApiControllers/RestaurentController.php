<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurent;
use App\Models\User;
use App\Models\Follow;
use App\Models\Commants;
use App\Http\Resources\GetAllComments;
use App\Http\Resources\GetAllFriendStory;
use App\Models\Story;
use App\Models\LikePost;
use App\Models\ActivityNotification;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GetMyNotifications;
use App\Http\Resources\UserResource;
use App\Http\Resources\GetAllFriendsPost;
use App\Http\Resources\GetAllCategoryWithFoods;
use App\Models\FoodCategory;
use App\Models\Foods;
use App\Http\Resources\GetAllRestaurent;
use Illuminate\Support\Facades\Http;

class RestaurentController extends Controller
{
    public function AddPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'place_id' => 'required',
            'user_id' => 'required',
            'restaurant_name' => 'required',
            'food_category' => 'required',
            'food_item' => 'required',
            'rating' => 'required',
            'review' => 'required',
            'dish_name' => 'required',
            'dish_picture' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('id',$request->user_id)->first();

        if($User)
        {
            if($request->hasFile('dish_picture'))
            {
                $file = $request->file('dish_picture');
                $image = date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('profileImages'), $image);
            }
            
            $Restaurent = Restaurent::create([
                'place_id' => $request->place_id,
                'user_id' => $request->user_id,
                'restaurant_name' => $request->restaurant_name,
                'food_category' => $request->food_category,
                'food_item' => $request->food_item,
                'rating' => $request->rating,
                'review' => $request->review,
                'dish_name' => $request->dish_name,
                'dish_picture' => 'profileImages/'.$image,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);
    
            return response()->json(['massage'=>'Post Added Successfully']);
        }
        else
        {
            return response()->json(['massage'=>'User Not Found']);
        }


    }

    public function LikePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $LikePost = LikePost::where('user_id',$request->user_id)->where('post_id',$request->post_id)->first();

        if($LikePost)
        {
            $ActivityNotification = ActivityNotification::where('user_id',$request->user_id)->where('post_id',$request->post_id)->first();
            
            $ActivityNotification->delete();
            $LikePost->delete();

            return response()->json(['message' => 'UnLike Successfully']);

        }
        else
        {
            $LikePost = LikePost::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'status' => '1'
            ]);

            $Restaurent = Restaurent::where('id',$LikePost->post_id)->first();

            $ActivityNotification = ActivityNotification::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'friend_id' => $Restaurent->user_id,
                'follow' => NULL,
                'status' => 'Like your post',
            ]);

            return response()->json(['message' => 'Like Successfully']);
        }
    }

    public function GetAllFriendPost(Request $request)
    {
        $Follow = Follow::select('friend_id')->where('user_id',$request->user_id)->get();

        $post = Restaurent::with(
                                    [
                                        'Likes',
                                        'Users'=>function($query){
                                            $query->select('id','name');
                                        },
                                        'UsersProfile' => function($query){ 
                                            $query->select('image','user_id');
                                        },
                                        'Comments' => function($query){ 
                                            $query->select('post_id','comments','user_id');
                                        },
                                       
                                        'Comments.User:id,name',
                                        'Comments.UsersProfile:user_id,image'
                                    ]
                                )
                                ->whereIn('user_id',$Follow)->orderBy('created_at','desc')->get();
        // return $post;
        return GetAllFriendsPost::collection($post);
    }

    public function AddComments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('id',$request->user_id)->first();
        $Restaurent = Restaurent::where('id',$request->post_id)->first();

        if($User)
        {
            if($Restaurent)
            {
                $Commants = Commants::create([
                    'user_id' => $request->user_id,
                    'post_id' => $request->post_id,
                    'comments' => $request->comment,
                ]);

                $Restaurent = Restaurent::where('id',$Commants->post_id)->first();

                $ActivityNotification = ActivityNotification::create([
                    'user_id' => $request->user_id,
                    'post_id' => $request->post_id,
                    'friend_id' => $Restaurent->user_id,
                    'follow' => NULL,
                    'status' => 'Commented on your post',
                ]);
        
                return response()->json(['message'=>'Success']);
            }
            else
            {
                return response()->json(['message'=>'Post Not Found']);
            }
        }
        else
        {
            return response()->json(['message'=>'User Not Found']);
        }
    }

    public function GetAllComments(Request $request)
    {
        $Commants = Commants::select('id', 'user_id', 'comments','created_at')->with(
                [
                    'UsersProfile' => function($query){
                        $query->select('image','user_id');
                    },
                    'User' => function($query){
                        $query->select('name','id');
                    },
                ]
            )->where('post_id',$request->post_id)->get();

        return response()->json(['Comment'=>$Commants]);
    }

    public function AddStory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'content' => 'required|mimes:mp4,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('id',$request->user_id)->first();

        if($User)
        {
            if($request->hasFile('content'))
            {
                $file = $request->file('content');
                $getExtension = $file->getClientOriginalExtension();
    
                if($getExtension == 'mp4')
                {
                    $Story = date('YmdHi').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('Story'), $Story);
                }
                else
                {
                    $Story = date('YmdHi').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('Story'), $Story);
                }
    
            }
            $Story = Story::create([
                'user_id' => $request->user_id,
                'contentType' => $getExtension,
                'content' => 'Story/'.$Story,
            ]);
    
            return response()->json(['massage'=>'Story Uploaded Successfully']);
        }
        else
        {
            return response()->json(['massage'=>'User Not Found']);
        }
    }

    public function GetStory(Request $request)
    {
        $Follow = Follow::select('friend_id')->where('user_id',$request->user_id)->get();
        $story = Story::with('Users')->select('user_id','contentType','content')->whereIn('user_id',$Follow)->get();
        return GetAllFriendStory::collection($story);
    }

    public function ActivityNotifications(Request $request)
    {
        $ActivityNotification = ActivityNotification::with(
            [
                'Users' => function($q)
                {
                    $q->select('id','name');
                },
                'UserProfile' => function($q)
                {
                    $q->select('user_id','image');
                },
            ]
        )->select('user_id','friend_id','status','created_at','post_id')->where('friend_id',$request->user_id)->get();
        // dd($request->all(),$ActivityNotification);

        return GetMyNotifications::collection($ActivityNotification);
    }

    public function SingleProfile(Request $request)
    {
        $User = User::with(
            [
                'Following',
                'Follow',
                'Post' => function($Query)
                {
                    $Query->select('user_id','dish_picture');
                },
                'ProfileSetup',
                'UserLanguages'
            ]
        )->where('id', $request->profile_id)->get();
        // return $User;

        return UserResource::collection($User);   
    }

    public function GetAllUsers(Request $request)
    {
        $User = User::with(
            [
                'Following',
                'Follow',
                'Post' => function($Query)
                {
                    $Query->select('user_id','dish_picture');
                },
                'ProfileSetup',
                'UserLanguages'
            ]
        )->where("id", "!=", $request->user_id)->where('name','LIKE',"%{$request->keyword}%")->get();

        return UserResource::collection($User);
    }

    public function GetAllCategoryWithFoods()
    {
        $FoodCategory = FoodCategory::select('id','food_category_name','images')->with(
                                                                                [
                                                                                    'Foods' => function ($q)
                                                                                    { 
                                                                                        $q->select('category_id','food_name');
                                                                                    },
                                                                                ])->get();
        return response()->json(['Status' => 1,'Foods' => $FoodCategory]);
        return $FoodCategory;
    }

    public function GetAllRestaurants(Request $request)
    {
        $location = $request->location;

        $myArray = explode(',', $location);

        $radius = (float)$request->radius;

        $name = $request->name;

        $response = Http::get('https://maps.googleapis.com/maps/api/place/search/json?location=' . (float)$myArray[0] . ', ' . (float)$myArray[1] . '&radius=' . $radius . '&name=' . $name . '&key=AIzaSyCzeJMBG7dupF95sa6qz5USqXYLJlGpjI4&type=restaurant');

        $results = $response['results'];

        // return $results;

        if ($results) {

            $plase_id = array();
            $height = array();

            foreach ($results as $result) 
            {
                $opening_hours = (isset($result['opening_hours']['open_now']) ? $result['opening_hours']['open_now'] : null);

                $height = (isset($result['photos']) ? $result['photos'][0]['height'] : null);

                $width = (isset($result['photos']) ? $result['photos'][0]['width'] : null);

                $photo_reference = (isset($result['photos']) ? $result['photos'][0]['photo_reference'] : null);


                $plase_id['place_id'] = $result['place_id'];
                $plase_id['opening_hours'] = $opening_hours;
                $plase_id['height'] = $height;
                $plase_id['width'] = $width;
                $plase_id['photo_reference'] = $photo_reference;

                if ($plase_id) 
                {
                    $result_data[] = $plase_id;
                }
                else 
                {
                    $result_data[] = null;
                }
            }


            $place_id_array = array();
            $opening_hours = array();


            foreach ($result_data as $colloction) {

                Restaurent::where('place_id', $colloction['place_id'])->update(
                    [
                        'open_now' => $colloction['opening_hours'],
                        'width' => $colloction['height'],
                        'height' => $colloction['height'],
                        'photo_reference' => $colloction['photo_reference'],
                    ]
                );
                $place_id_array[] = $colloction['place_id'];
                
            }

            $Restaurents = Restaurent::whereIn('place_id', $place_id_array)->get();
            
            return GetAllRestaurent::collection($Restaurents);
        } 
        else 
        {
            return response()->json(["data" => []]);
        }
    }

    public function GetRestaurantMenuPost(Request $request)
    {
        $Restaurent = Restaurent::with(
                                        ['Likes',
                                        'Comments' => function($query){
                                            $query->select('post_id','comments');
                                        }
                                        ]
                                        )->where('place_id',$request->place_id)->get();
        return response()->json(["Posts" => $Restaurent]);
    }
}