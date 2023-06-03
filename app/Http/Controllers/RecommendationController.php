<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\telegram;

use App\Models\user_id ;
use App\Events\recommend;
use Illuminate\Http\Request;
use App\Models\recommendation;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use App\Http\Resources\RecommendationResource;
use App\Http\Requests\StorerecommendationRequest;
use App\Http\Requests\UpdaterecommendationRequest;

 class RecommendationController extends Controller
{



//   public function __construct()
//   {
//     $this->middleware('CheckLogin');
//   }

    public function index()
    {

        // $recommendation = recommendation::with('plan')->get();

        // return $recommendation;
        $recommendation = recommendation::with(['user' =>function($e){
            $e->select('id', 'name');}])->orderBy('created_at', 'desc')->get();;
        return response()->json($recommendation);
    }


    public function store(StorerecommendationRequest $request)
    {
            $request['active']=1;
            $request['archive']=0;
            $request['img']=$this->convertTextToImage($request->desc);
            $test=recommendation::create($request->all());
            event (new recommend ($test));
            $this->telgrame($request->desc);
            return response()->json($test);
    }


    public function show($id)
    {
        $user = recommendation::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->find($id);

        if (!$user) {
            return response()->json(['message' => 'request not found'], 404);
        }
        return response()->json($user);


    }


    public function update(UpdaterecommendationRequest $request, recommendation $recommendation)
    {

    }


    public function destroy(recommendation $id)
    {

        $user = recommendation::find($id);

        if (!$user) {
            return response()->json(['message' => 'request not found'], 404);
        }
        return response()->json($user);
    }

    function convertTextToImage($text)
{
    // Create a new image instance using Intervention Image
    $image = Image::canvas(100, 200);

    // Set the font properties
    // $font = $fontPath; // Path to your desired font file
    $color = '#000'; // Text color in hexadecimal format
    $x = 0; // X-coordinate for the starting position of the text
    $y = 1; // Y-coordinate for the starting position of the text
    $fontSize=2500;
    $image_Name=time(). '.' .'jpg';
    $imagePath=public_path('Recommendation/'.$image_Name);

    // Add the text to the image
    $image->text($text, $x, $y, function ($font) use ( $fontSize, $color) {
        // $font->file($fontPath);
        $font->size($fontSize);
        $font->color($color);
        $font->align('left');
        $font->valign('top');
    });

    // Save the image
    $image->save($imagePath);


    return $image_Name;
}

// function for telgram
public function telgrame()
{

        $teles=telegram::get();

        // img url must is Https
       $imageUrl ='https://th.bing.com/th/id/R.4c5f4b654d397dbf388439c146fc2a43?rik=tAXLyC2QQDAW4w&riu=http%3a%2f%2fwww.tandemconstruction.com%2fsites%2fdefault%2ffiles%2fstyles%2fproject_slider_main%2fpublic%2fimages%2fproject-images%2fIMG-Student-Union_6.jpg%3fitok%3dSIO_SJym&ehk=J7Rf60RWZAMlFREdj%2f7pdLWdGMn%2bS07tQsou0pZGgIA%3d&risl=&pid=ImgRaw&r=0';

    $client = new Client();

    foreach ($teles as $tele)
     {
        $response = Http::post(
            "https://api.telegram.org/bot{$tele->token}/sendPhoto",
            [
                'chat_id' => $tele->merchant,
                'photo' => $imageUrl,
                'caption' => 'Image caption',
            ]
        );


    }

return 150;










}
}
