<html>

<head>            

           <title>Video  Chat</title>                  

           <script         type="text/javascript"         src="device_dialog.js"></script>             

          <script         type="text/javascript"         src="wow_feature.js"></script>             

           <script         type="text/javascript">

                window.onload =         function () {

                          var transceiver = new          MediaStreamTransceiver("ws://150.132.141.60:8880/delayswitch?sid=0");

                                    var videoDevice = document.getElementsByTagName("device")[0];

   

                                videoDevice.onchange = function (evt) {

                                        var videoStream = videoDevice.data;

                                        var selfView = document.getElementById("self_view");

                                        // exclude audio from the self view

                                        selfView.src = videoStream.url + "#video";

                                        selfView.play();

                                // set the stream to share

                                        transceiver.localStream = videoStream;

                                    };

                            transceiver.onconnect = function () {

                                        var remoteVideo =          document.getElementById("remote_video");

                                     // play the incoming stream

                                    remoteVideo.src = transceiver.remoteStream.url;

                                    remoteVideo.play();

                                    };

                        }

                     </script>             

           </head>             

         <body>             

         <div><device         type="media"></div>             

         <div         style="float:left">             

         <p>Self-view:</p>     

         <video         width="320"         height="240"         id="self_view"></video>             

         </div>             

         <div         style="float:left">             

        <p>Remote          video:</p>     

         <video         width="320"         height="240"         id="remote_video"></video>             

         </div>            

      </body>           

      </html>

