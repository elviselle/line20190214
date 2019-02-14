<?php
  	$json_str = file_get_contents('php://input'); //接收request的body
  	$json_obj = json_decode($json_str); //轉成json格式
  
  	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
  	//fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
  	$sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  	$sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  	$sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  	$msg_json = '{
  "type": "bubble",
  "hero": {
    "type": "image",
    "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_3_movie.png",
    "size": "full",
    "aspectRatio": "20:13",
    "aspectMode": "cover",
    "action": {
      "type": "uri",
      "uri": "http://linecorp.com/"
    }
  },
  "body": {
    "type": "box",
    "layout": "vertical",
    "spacing": "md",
    "contents": [
      {
        "type": "text",
        "text": "BROWNS ADVENTURE\nIN MOVIE",
        "wrap": true,
        "weight": "bold",
        "gravity": "center",
        "size": "xl"
      },
      {
        "type": "box",
        "layout": "baseline",
        "margin": "md",
        "contents": [
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
          },
          {
            "type": "text",
            "text": "4.0",
            "size": "sm",
            "color": "#999999",
            "margin": "md",
            "flex": 0
          }
        ]
      },
      {
        "type": "box",
        "layout": "vertical",
        "margin": "lg",
        "spacing": "sm",
        "contents": [
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Date",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "Monday 25, 9:00PM",
                "wrap": true,
                "size": "sm",
                "color": "#666666",
                "flex": 4
              }
            ]
          },
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Place",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "7 Floor, No.3",
                "wrap": true,
                "color": "#666666",
                "size": "sm",
                "flex": 4
              }
            ]
          },
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Seats",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "C Row, 18 Seat",
                "wrap": true,
                "color": "#666666",
                "size": "sm",
                "flex": 4
              }
            ]
          }
        ]
      },
      {
        "type": "box",
        "layout": "vertical",
        "margin": "xxl",
        "contents": [
          {
            "type": "spacer"
          },
          {
            "type": "image",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/linecorp_code_withborder.png",
            "aspectMode": "cover",
            "size": "xl"
          },
          {
            "type": "text",
            "text": "You can enter the theater by using this code instead of a ticket",
            "color": "#aaaaaa",
            "wrap": true,
            "margin": "xxl",
            "size": "xs"
          }
        ]
      }
    ]
  }
}';
  	$response = array (
		"replyToken" => $sender_replyToken,
		"messages" => array (
			array (
				"type" => "flex",
				"altText" => "This is a Flex Message",
				"contents" => json_decode($msg_json)
			)
		)
  	);
			
  	fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  	$header[] = "Content-Type: application/json";
  	$header[] = "Authorization: Bearer ROvAyOpIkM7pfd+e7wiwKk1stCMJHFpzE5M5JgKsa7f/YrISMkSb0vAwS66oqI5huJVNNsIFVLR6yiNXzCYxmf9gMt4kQPCl+ZOa+Mf7IjFUfqyEIa5SkzlFeOvPhgPvkzfogF0BLC54cl9XMZ4wMAdB04t89/1O/w1cDnyilFU=";
  	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  	$result = curl_exec($ch);
  	curl_close($ch);
?>
