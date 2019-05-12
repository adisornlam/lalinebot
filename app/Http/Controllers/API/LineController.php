<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;

use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\ComponentType;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;

use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;


use App\Line;


class LineController extends Controller
{
    protected $bot;

    public function __construct() {
        $httpClient = new CurlHTTPClient(env('LINE_ACCESS_TOKEN'));
        $this->bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return response()->json($request, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function buttonMessagePush(Request $request) {
        // return $this->sendResponse('Succeeded', 'Line push successfully.');
        $templateBuilder = new ButtonTemplateBuilder(
            'Menu',
            'Please select',
            'https://firstblood.io/pages/wp-content/uploads/2018/07/dota-2-hero-guide-970x570.jpg',
            [
                new MessageTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                new UriTemplateActionBuilder('Buy', 'http://example.com/page/123')
            ]
        );
        return $this->push($request->to, new TemplateMessageBuilder('This is a buttons template', $templateBuilder));
    }


    public function carouselColumnMessagePush(Request $request) {
        $templateBuilder = new CarouselTemplateBuilder([
            new CarouselColumnTemplateBuilder(
                'this is menu',
                'description',
                'https://firstblood.io/pages/wp-content/uploads/2018/07/dota-2-hero-guide-970x570.jpg',
                [
                    new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=111'),
                    new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=111'),
                    new UriTemplateActionBuilder('View detail', 'http://example.com/page/111')
                ]
            ),
            new CarouselColumnTemplateBuilder(
                'this is menu',
                'description',
                'https://firstblood.io/pages/wp-content/uploads/2018/07/feature-970x570.jpg',
                [
                    new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=111'),
                    new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=111'),
                    new UriTemplateActionBuilder('View detail', 'http://example.com/page/111')
                ]
            )
        ]);

        return $this->push($request->to, new TemplateMessageBuilder('this is a carousel template', $templateBuilder));
    }

    protected function push($to, $messageBuilder) {
        $response = $this->bot->pushMessage($to, $messageBuilder);
        if ($response->isSucceeded()) {
            return $this->sendResponse('Succeeded', 'Line push successfully.');
        }

        // Failed
        return $this->sendResponse(json_decode($response->getRawBody()), 'Line push error.');
    }


    
}
